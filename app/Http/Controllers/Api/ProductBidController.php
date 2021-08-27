<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ProductBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Product;
class ProductBidController extends Controller
{
    public function biding(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'product_id' => 'required',
            'vendor_id' => 'required',
            'bid_price' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        $check = ProductBid::where('product_id', $request->product_id)
                            ->where('user_id', $request->user_id)
                            ->first();

        if($check)
        {
            $status = 'True';
            $message = 'You Already Bid this Product..';
            return response()->json(compact('status','message'),201);
        }

        $bid = new ProductBid();
        $bid->product_id = $request->product_id;
        $bid->vendor_id = $request->vendor_id;
        $bid->user_id   = Auth::user()->id;
        $bid->bid_price = $request->bid_price;

        $bid->save();
                $product=Product::where('id',$bid->product_id)->first();
                $bid->setAttribute('product',$product);
        if($bid)
        {
            $status = 'True';
            $message = 'Product Biding SuccessFully...';
            return response()->json(compact('status','message','bid'),201);
        }
        else
        {
            $status = 'False';
            $message = 'Something Went Wrong';
            return response()->json(compact('status','message'),201);
        }
    }

    public function bid_counter(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bid_id' => 'required',
            'counter' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        $bid = ProductBid::findOrFail($request->bid_id);
        $bid->counter = $request->counter;

        $bid->update();

        if($bid)
        {
            $status = 'True';
            $message = 'Product Biding Counter SuccessFully...';
            return response()->json(compact('status','message','bid'),201);
        }
        else
        {
            $status = 'False';
            $message = 'Something Went Wrong';
            return response()->json(compact('status','message'),201);
        }
    }

    public function bid_status(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bid_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        $bid = ProductBid::findOrFail($request->bid_id);
        $bid->status = $request->status;

        $bid->update();

        if($bid)
        {
            $status = 'True';
            $message = 'Product Biding Status Change SuccessFully...';
            return response()->json(compact('status','message','bid'),201);
        }
        else
        {
            $status = 'False';
            $message = 'Something Went Wrong';
            return response()->json(compact('status','message'),201);
        }
    }
}
