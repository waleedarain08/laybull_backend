<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Reservation,ReservationBooking,ReservationBookingDetail,ReservationTransaction};
use Illuminate\Support\Facades\Validator;
use Exception;
use DB;


class ReservationBookingController extends Controller
{
    public $successStatus = 200;
    public function store(Request $request)
    {
        $data = $request->all();
        extract($data);
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|exists:users,id',
            // 'price' => 'required',
            'tax' => 'required',
            'vendor_id' => 'required',
            'reservation_id'=>'required',
            'advance'=>'required'
        ]);
        
        $message = "Reservation Booking Is done Successfully";
        if($validator->fails())
        {
            return response()->json(['error'=> $validator->errors()],401);
        }
        try 
        {   
            DB::beginTransaction();
            $data = $request->all();
            // print_r($data);
            // exit;
            extract($data);
          
            // print_r($booking->toArray());
            // exit;
            $model = new Reservation();
            $item = $model->find($reservation_id);
            $allitem = $item->price;
            $percent =(double)$advance/100;
            
            $price2 = $allitem*$percent;
            $balance = $item->price - $price2;
            $totalprice = $balance + $price2;


            $booking = new ReservationBooking();
            $booking->user_id = (int)$user_id;
            $booking->total_price = (double)$price2;
            $booking->tax = (double)$tax;
            $booking->payment_method = isset($payment_method) && $payment_method == 'card' ? 'card' : 'cod';
            $booking->save();

            $rbd = new ReservationBookingDetail();
            $rbd->reservation_booking_id = (int)$booking->id;
            $rbd->vendor_id = (int)$vendor_id;
            $rbd->reservation_id = (int)$item->id;
            $rbd->price = (double)$price2;
            $rbd->balance = (double)$balance;
            $rbd->quantity = 1;
            $rbd->total_price = (double)$allitem;
            $rbd->save();
            
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
                    'amount' => ((double)$price2)*100,
                    'currency' => 'usd',
                    'source' => $token->id,
                    'description' => 'payment successfully made',
                 ]);
            }
                
              $transaction = new ReservationTransaction();
              $transaction->vendor_id = (int)$vendor_id;
              $transaction->user_id = (int)$user_id;
              $transaction->reservation_booking_id = (int)$booking->id;
              $transaction->amount = (double)$price2;
              $transaction->type = $payment_method;
              $transaction->object = isset($paymentObject) && $paymentObject ? json_encode($paymentObject) : null;
              $transaction->save();
            //   print _r($transaction->toArray());
            //   exit;
              DB::commit();
            return response()->json(['success'=>$message],$this->successStatus);
        }
        catch (Exception $e) 
        {
            print_r($e->getMessage());
            exit;
            DB::rollback();
            \Log::error($e->getMessage());
            return response()->json(['error' => 'something went wrong'],401);
        }
    }
    public function inProgressReservation($id)
    {
        $model = new ReservationBooking();
        $record = $model->where('user_id',$id)->whereIn('status',['pending','accepted'])->with(['details.reservation','details.vendors.detail','details.vendors.locations','users'])->get();
        if($record)
        {
            return response()->json(['success' => $record]);
        }
        else
        {
            return response()->json(['error' => 'something went wrong']);
        }
    }
    public function completedReservation($id)
    {
        $model = new ReservationBooking();
        $record = $model->where('user_id',$id)->whereIn('status',['rejected','completed'])->with(['details.reservation','details.vendors.detail','details.vendors.locations','users'])->get();
        if($record)
        {
            return response()->json(['success' => $record]);
        }
        else
        {
            return response()->json(['error' => 'something went wrong']);
        }
    }

}
