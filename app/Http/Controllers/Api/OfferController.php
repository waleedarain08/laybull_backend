<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ProductBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
class OfferController extends Controller
{
    public function offers()
    {
        $bids=ProductBid::where(function ($query) {
    $query->where('user_id', Auth::user()->id)->where('counter',NULL);
})->orwhere(function($query) {
    $query->where('vendor_id', Auth::user()->id)
        ->where('counter', '!=', NULL);	
})->get();

foreach($bids as $bid){
                $product=Product::with('images')->with('user')->where('id',$bid->product_id)->first();
                $bid->setAttribute('product',$product);
            }

//         $bids1 = ProductBid::where('user_id', Auth::user()->id)->get();
//   foreach($bids1 as $bid){
//                 $product=Product::with('images')->with('user')->where('id',$bid->product_id)->first();
//                 $bid->setAttribute('product',$product);
//             }
            
//         $bids2 = ProductBid::where('vendor_id', Auth::user()->id)->where('counter','!=',NULL)->get();
//   foreach($bids2 as $bid){
//                 $product=Product::with('images')->with('user')->where('id',$bid->product_id)->first();
//                 $bid->setAttribute('product',$product);
//             }
//             array_push($bids1,$bids2);
        if($bids)
        {
            $status = 'True';
            $message = 'You Complete Offers...';
            return response()->json(compact('status', 'message', 'bids'),201);
        }
        else
        {
            $status = 'False';
            $message = 'You Don`t Send any Offers';
            return response()->json(compact('status', 'message'),201);
        }
    }
    public function collectOffers()
    {
          $bids=ProductBid::where(function ($query) {
    $query->where('user_id', Auth::user()->id)->where('counter','!=',NULL)->where('status','=',NULL);
})->orwhere(function($query) {
    $query->where('vendor_id', Auth::user()->id)
        ->where('counter', NULL)
        ->where('status', NULL);
})->get();

foreach($bids as $bid){
                $product=Product::with('images')->with('user')->where('id',$bid->product_id)->first();
                $bid->setAttribute('product',$product);
            }

        
        // $bids = ProductBid::where('vendor_id', Auth::user()->id)->where('status',NULL)->where('counter',NULL)->get();
        //     foreach($bids as $bid){
        //         $product=Product::with('images')->with('user')->where('id',$bid->product_id)->first();
        //         $bid->setAttribute('product',$product);
        //     }
        if($bids)
        {
            $status = 'True';
            $message = 'Your All Recieved Offers...';
            return response()->json(compact('status', 'message', 'bids'),201);
        }
        else
        {
            $status = 'False';
            $message = 'You Dont Have Any Offers';
            return response()->json(compact('status', 'message'),201);
        }
    }
}
