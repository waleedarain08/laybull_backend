<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{StoreBooking,StoreBookingDetails};

class StoreBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $model = new StoreBooking();
        if(auth()->user()->role == 'admin')
        {
            $records = $model->with(['details','user'])->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $records = $model->whereHas('details',function($q){
                $q->where('vendor_id',auth()->user()->id);
            })->with(['details','user'])->latest()
            ->paginate(config('app.pagination_length'));
        }
        return view('storebooking.index', compact('records'));


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
        $model = new StoreBooking();
        $records = $model->with(['details','user'])->find($id);
        $modeldetails = new StoreBookingDetails();
        $recordsdetails = $modeldetails->where('store_booking_id',$id)->with(['storebooking','store','vendor'])->get();
        return view('storebooking.detail', compact(['records','recordsdetails']));
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
}
