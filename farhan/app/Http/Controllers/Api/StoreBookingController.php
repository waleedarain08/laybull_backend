<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\{StoreBooking,StoreBookingDetails, StoreTransaction,User,Rider};
use Exception;
use DB;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Kreait\Firebase\Storage;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Hash;

class StoreBookingController extends Controller
{
    public $successStatus = 200;
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|exists:users,id',
            'total_price' => 'required',
            'tax' => 'required',
            'instruction'=>'nullable',
            'items' => 'required',
            'vendor_id' => 'required',
            'rider_type'=>'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required',
            'delivery_charges' => 'nullable',
        ]);
        $message = "Store Booking is Done Successfully";
        if($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()],401);
        }
        try 
        {   
            DB::beginTransaction();
            $data = $request->all();
            extract($data);
            $booking =  new StoreBooking();            
            $booking->user_id = (int)$user_id;
            $booking->total_price = (double)$total_price;
            $booking->tax = (double)$tax;
            $booking->instruction = isset($instruction) && $instruction ? $instruction : '';
            $booking->rider_type = $rider_type;
            $booking->payment_method = isset($payment_method) && $payment_method == 'card' ? 'card' : 'cod';
            $booking->latitude = $latitude;
            $booking->longitude = $longitude;
            $booking->address = $address;
            $booking->delivery_charges = $delivery_charges;
            $booking->save();

            foreach(json_decode($items) as $key=>$item)
            {
                $quantity = (int)$item->orderquantity;
                $price = (double)$item->price;
                $total = $quantity*$price;
                
                $sbd = new StoreBookingDetails();
                $sbd->store_booking_id = (int)$booking->id;
                $sbd->quantity = (int)$item->orderquantity;
                $sbd->store_id = (int)$item->id;
                $sbd->vendor_id = (int)$vendor_id;
                $sbd->price = (double)$item->price;
                $sbd->total_price = (double)$total;
                $sbd->save();
            }

            if(isset($payment_method) && $payment_method == 'card'){
                
                $stripe = new \Stripe\StripeClient(
                    'sk_test_51H037GFyymxjz4jy4GafopsPh7PpqJPGeszisBbX2VSj1x4xRgl43xup9acF1zHppjC5qyXlcnvmH5jHf8OY708M000bY2zR8w'
                );
        
                $token = $stripe->tokens->create([
                    'card' => [
                      'number' => $card_number,
                      'exp_month' => (int)$expiry_month,
                      'exp_year' => (int)$expiry_year,
                      'cvc' => $cvc,
                    ],
                    //   'card' => [
                    //   'number' => '4242424242424242',
                    //   'exp_month' => 12,
                    //   'exp_year' => 2021,
                    //   'cvc' => '314',
                    // ],
                ]);
                
                $paymentObject = $stripe->charges->create([
                    'amount' => ((double)$total_price)*100,
                    'currency' => 'usd',
                    'source' => $token->id,
                    'description' => 'payment successfully made',
                 ]);
            }

              $transaction = new StoreTransaction();
              $transaction->vendor_id = (int)$vendor_id;
              $transaction->user_id = (int)$user_id;
              $transaction->store_booking_id = $booking->id;
              $transaction->amount = (double)$total_price;
              $transaction->type = $payment_method;
              $transaction->object = isset($paymentObject) && $paymentObject ? json_encode($paymentObject) : null;
              $transaction->save();

            DB::commit();
            return response()->json(['success'=>$message],$this->successStatus);
        } 
        catch (Exception $e)
        {
             DB::rollback();
            \Log::error($e->getMessage());
            return response()->json(['error'=>'something went wrong'],401);
        }

    }
    
    public function completedOrders($user_id)
    {
        try
        {
            $model = new StoreBooking();
            $records = $model->whereHas('details')
                ->where('user_id', $user_id)->whereIn('status', ['rejected', 'completed','vendor_rejected'])->with(['details.store','details.vendor'=>function($q){
                    $q->with(['detail'=>function($q){
                        $q->select('user_id','image');
                    }])->with('locations');
                }])->latest()->get();
                $riderModel = new Rider();
                $userModel = new User();
                $newRecords = $records->map(function($newRecord, $key) use($riderModel, $userModel)
                {
                    if($newRecord->rider_id)
                {
                    $rider = $riderModel->where('firebase_id',$newRecord->rider_id)->first();
                    $newRecord->rider =$userModel->with('detail')->find($rider->rider_id); 
                }
                else
                $newRecord->rider = null;               
                return $newRecord;
                });

            if(count($newRecords) > 0)
            
                return response()->json(['success'=> $newRecords], $this->successStatus);        
            else
                return response()->json(['error' => 'something went wrong'], 401);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => 'something went wrong'], 401);
        }
    }

    public function inProgressOrders($user_id)
    {
        try
        {
            $error['message'] = '';
            $model = new StoreBooking();
            $records = $model->whereHas('details')
                ->where('user_id', $user_id)->whereIn('status', ['pending', 'accepted','vendor_accepted','pickup'])->with(['details.store', 'details.vendor' => function($q){
                $q->with(['detail' => function($q){
                    $q->select('user_id', 'image');
                }])->with('locations');
            }])->latest()->get();
            
            $riderModel = new Rider();
            $userModel = new User();
            $newRecords = $records->map(function($newRecord, $key) use($riderModel,$userModel)
            {
                if($newRecord->rider_id)
                {
                    $rider = $riderModel->where('firebase_id',$newRecord->rider_id)->first();
                    $newRecord->rider = $userModel->with('detail')->find($rider->rider_id);
                }
                else
                
                $newRecord->rider = null;               
                return $newRecord;
                
            });

            if(count($newRecords) > 0)
            return response()->json(['success'=> $newRecords], $this->successStatus);        
            else{
                $error['message'] = 'something went wrong';
                return response()->json(['error' => $error], 404);
            }
        }
        catch (Exception $e)
        {
            $error['message'] = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }
    }

    public function inProgressOrdersVendor($vendorId)
    {
        try
        {
            $storeModel = new StoreBooking();
            $records = $storeModel->whereIn('status', ['pending', 'accepted','vendor_accepted','pickup'])->whereHas('details', function($q) use($vendorId){
                $q->where('vendor_id', $vendorId);
            })->with(['details.store', 'user.detail'])->latest()->get();
            $riderModel = new Rider();
            $userModel = new User();
            $newRecords = $records->map(function($newRecord, $key) use($riderModel,$userModel)
            {
                if($newRecord->rider_id)
                {
                    $rider = $riderModel->where('firebase_id',$newRecord->rider_id)->first();
                    $newRecord->rider = $userModel->with('detail')->find($rider->rider_id);
                }
                else
                $newRecord->rider = null;               
                return $newRecord;
            });

            if(count($newRecords) > 0)
            {
                return response()->json(['success'=> $newRecords], $this->successStatus);
            }
            else
            {
                $error['message'] = 'something went wrong';
                return response()->json(['error' => $error], 404);
            }            
        }
        catch (Exception $e)
        {
            $error['message'] = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }
       
    }
    public function completedOrdersVendor($vendorId)
    {
        try
        {
            $model = new StoreBooking();
            $records = $model->whereIn('status', ['rejected', 'completed','vendor_rejected'])->whereHas('details',function($q) use($vendorId){
                $q->where('vendor_id',$vendorId);
            })->with(['details.store','user.detail'])->latest()->get();

            $riderModel = new Rider();
            $userModel = new User();
            $newRecords = $records->map(function($newRecord, $key) use($riderModel,$userModel)
            {
                if($newRecord->rider_id)
                {
                    $rider = $riderModel->where('firebase_id',$newRecord->rider_id)->first();
                    $newRecord->rider = $userModel->with('detail')->find($rider->rider_id);
                }
                else
                $newRecord->rider = null;               
                return $newRecord;
            });

            if(count($newRecords) > 0)
                return response()->json(['success'=> $newRecords], $this->successStatus);        
            else
                return response()->json(['error' => 'something went wrong'], 401);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => 'something went wrong'], 401);
        }
    }
    public function driverRequest(Request $request)
    {
        
       try
       {
            extract($request->all());
            $model = new StoreBooking();
            $record = $model->with(['details','user','details.vendor'=>function($q){
                $q->with('detail','locations')->get();
            }])->find($id);
            if(!is_null($record))
            {
                $theta = $record->longitude-$record->details[0]->vendor->locations[0]->longitude;
                $dist = sin(deg2rad($record->latitude)) * sin(deg2rad($record->details[0]->vendor->locations[0]->latitude)) +  cos(deg2rad($record->latitude)) * cos(deg2rad($record->details[0]->vendor->locations[0]->latitude)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $milesstring = sprintf("%.2f",$miles);
                $mileshort = (double)$milesstring;
                $dur = ($miles/40)*60;
                $durstring = sprintf("%.2f",$dur);
                $durshort = (double)$durstring;
                $record->save();
                $factory = (new Factory)->withServiceAccount(__DIR__.'\firbaseKey.json');
                $database = $factory->createDatabase();
                $data = $request->all();
                extract($data);
                $ref = $database->getReference('Request');
                $key = $ref->push()->getkey();
                $ref->getChild($key)->set([
                'BookingType'=>'store',
                'BookingId'=>$record->id,
                'CustomerId'=>$record->user_id,
                'CustomerName'=>$record->user->name,
                'ToAddress'=>$record->address,
                'ToLatitude'=>$record->latitude,
                'ToLongitude'=>$record->longitude,
                'FromAddress'=>$record->details[0]->vendor->locations[0]->address,
                'FromLatitude'=>$record->details[0]->vendor->locations[0]->latitude,
                'FromLongitude'=>$record->details[0]->vendor->locations[0]->longitude,
                'price'=>$record->total_price,
                'RequestId'=> $key,
                'RideDate'=>$record->created_at,
                'RideTime'=>$record->created_at,
                'ServiceBudget'=> "0",
                'ServiceType'=> "Bike",
                'Serviceimage'=> $record->details[0]->vendor->detail->image,
                'compareTime'=> " ",
                'distance'=> $mileshort,
                'duration'=> $durshort,
                'isPanel'=> true,
                'isAccepted'=> false,
                'isJourneyCancelled'=> false,
                'isJourneyEnded'=> false,
                'isJourneyStarted'=> false,
                'isPickUp'=> false,
                'isShedule'=> false,
                ]);
                return response()->json(['success'=> $record], $this->successStatus);
            } 
            else
            {
            return response()->json(['success'=> 'Id Not found'], $this->successStatus);
            }
        }
       catch (Exception $e)
       {
        $error['message'] = $e->getMessage();
        return response()->json(['error' => $error], 404);
       }
    }
    public function driverstatus(Request $request)
    {
        try
       {
           $validator = Validator::make($request->all(),[
            'booking_id'=>'required',
            'status' => 'required',
            'rider_id'=>'required|string',
            ]);
            $data = $request->all();
            extract($data);
            $model = new StoreBooking();
            $record = $model->with(['details.vendor'=>function($q)
                {
                    $q->with('detail','locations'); 
                },'user'])->find($booking_id);
             $ridermodel = new Rider;
             $rider = $ridermodel->where('firebase_id',$rider_id)->with('user')->first();
            if($status == 'accepted')
            {
                $record->status = $status;
                $record->rider_id = $rider->firebase_id; 
                $record->save();
                return response()->json(['success'=> $record,'rider'=>$rider], $this->successStatus);
            }
            elseif($status == 'pending')
            {
                $record->status = $status;
                $record->rider_id = null;
                $record->save();
                return response()->json(['success'=> $record,'rider'=>''], $this->successStatus);
            }
            elseif($status == 'pickup')
            {
                $record->status = $status;
                $record->rider_id = $rider->firebase_id;
                $record->save();
                return response()->json(['success'=> $record,'rider'=>$rider], $this->successStatus);
            }
            elseif($status == 'rejected')
            {
                $record->status = $status;
                $record->rider_id = $rider->firebase_id;
                $record->save();
                return response()->json(['success'=> $record,'rider'=>$rider], $this->successStatus);
            }
            elseif($status == 'completed')
            {
                $record->status = $status;
                $record->rider_id = $rider->firebase_id;
                $record->save();
                return response()->json(['success'=> $record,'rider'=>$rider], $this->successStatus);
            }
            else
            {
                return response()->json(['success'=> 'something went wrong'], $this->successStatus);
            }
        }
       catch (Exception $e)
        {
            $error['message'] = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }
    }
     public function vendorStatus(Request $request)
    {
       try 
       {
            $validator = Validator::make($request->all(),[
            'booking_id'=>'required',
            'status' => 'required',
            'vendor_id'=>'required',
            ]);
            $data = $request->all();
            extract($data);
            $model = new StoreBooking();
            $record = $model->with(['details'])->find($booking_id); 

            if($record->details[0]->vendor_id == $vendor_id)
            {
            if($status == 'vendor_accepted')
            {
                $record->status = $status;
                $record->save();
                return response()->json(['success'=>$record],$this->successStatus);

            }
            elseif($status == 'vendor_rejected')
            {
                $record->status = $status;
                $record->rider_id = null;
                $record->save();
                return response()->json(['success'=>$record],$this->successStatus);
            }
            else
            {
                return response()->json(['Error'=>'something went wrong'],$this->successStatus);
            }
        }
        else
        {
            return response()->json(['Error'=>'Invalid Id'],$this->successStatus);
        }
        
       }
       catch (Exception $e)
       {
           $error['message'] = $e->getMessage();
           return response()->json(['error' => $error], 404);
       }
    }
}
