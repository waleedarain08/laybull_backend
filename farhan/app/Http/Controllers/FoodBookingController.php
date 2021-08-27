<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{FoodBooking,FoodBookingDetail};
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Kreait\Firebase\Storage;
use Google\Cloud\Storage\StorageClient;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Exception;

class FoodBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new FoodBooking();
        if(auth()->user()->role == 'admin')
        {
            $records = $model->with(['details','user'])->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $records = $model->whereHas('details', function($q){
                $q->where('vendor_id', auth()->user()->id);
            })->with(['details','user'])->latest()
            ->paginate(config('app.pagination_length'));
        }       
            
        return view('foodbooking.index', compact('records'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = new FoodBooking();
        $records = $model->with(['details','user'])->find($id);
        $modeldetails = new FoodBookingDetail();
        $recordsdetails = $modeldetails->where('food_booking_id',$id)->with(['foodbooking','food','vendor'])->get();
        // print_r(json_encode($records));exit;
        return view('foodbooking.detail', compact(['records','recordsdetails']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
   public function status(Request $request)
    {
        extract($request->all());

        $model = new FoodBooking();
        $record = $model->with(['details','user','details.vendor'=>function($q){
            $q->with('detail','locations')->get();
        }])->find($id);

        try{
      
        if($status =='pending')
        {
            $record->status = $status;
            $record->save();
            return redirect()->back();
        }
        elseif($status =='vendor_accepted')
        {
            
            $record->status = $status;
            $record->save();
            if($record->rider_type == 'AK Bookers Rider')
            {
                $factory = (new Factory)->withServiceAccount(__DIR__.'/Api/firbaseKey.json');
            $database = $factory->createDatabase();
            $data = $request->all();
            extract($data);
                $ref = $database->getReference('Request');
                $key = $ref->push()->getkey();
                $ref->getChild($key)->set([
                'FoodBookingId'=>$record->id,
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
                'distance'=> " ",
                'duration'=> " ",
                'isPanel'=> true,
                'isAccepted'=> false,
                'isJourneyCancelled'=> false,
                'isJourneyEnded'=> false,
                'isJourneyStarted'=> false,
                'isPickUp'=> false,
                'isShedule'=> false,
                ]);
            }
            
            return redirect()->back();
        }
        elseif($status =='rejected')
        {
            $record->status = $status;
            $record->save();
            return redirect()->back();
        }
        elseif($status =='completed')
        {
            $record->status = $status;
            $record->save();
            return redirect()->back();
        }
        }catch(Exception $e){
            print_r($e->getMessage());exit;
        }        
    }
   
}
