<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\StoreBookingDetails;
use Illuminate\Support\Facades\Validator;
use Exception;

class StoreBookingDetailController extends Controller
{
    public $successStatus = 200;
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'store_booking_id'=>'required|integer|exists:store_booking,id',
            'qty'=>'required',
            'store_id'=>'required|integer|exists:store_product,id',
            'vendor_id'=>'required|integer|exists:users,id',
            'price'=>'required',
            'total_price'=>'required'
        ]);
        $message = 'Store Booking Details is created Successfully';
        if($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()],401);
        }
        try
        {
            $data = $request->all();
            extract($data);
            $gbd = new StoreBookingDetails();
            $gbd->store_booking_id = $store_booking_id;
            $gbd->quantity = $qty;
            $gbd->store_id = $store_id;
            $gbd->vendor_id = $vendor_id;
            $gbd->price = $price;
            $gbd->total_price = $total_price;
            $gbd->save();
            return response()->json(['success'=>$message],$this->successStatus);

        }
        catch (Exception $e)
        {
            return response()->json(['error'=>'something went wrong'],401);
        }
    }

}
