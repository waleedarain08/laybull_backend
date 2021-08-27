<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ProductBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function offers()
    {
        $bids = ProductBid::where('user_id', Auth::user()->id)->get();

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
        $bids = ProductBid::where('vendor_id', Auth::user()->id)->get();

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
