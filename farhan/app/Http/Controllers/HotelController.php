<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Hotel;
use Exception;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model =  new Hotel();
        if(auth()->user()->role=='admin')
        {
            $record = $model->with('user')->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $record = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
        }
        return view('hotel.index', compact('record') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $helperObject = new Helper();
        $userrecords = $helperObject->users('hotel');
        return view('hotel.create', compact('userrecords'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
           
            $data =$request->all();
            extract($data);
            $model = new Hotel();
            $model->name = $name;
            if(auth()->user()->role == 'admin')
            {
                $model->vendor_id = $request->vendor;
            }
            elseif(auth()->user()->role == 'vendor')
            {
                $model->vendor_id = auth()->user()->id;
            }
          
            $model->description = $description;
            $model->address = $address;
            $model->phone = $phone;
            $model->email = $email;
            $model->price = $price; 
            $model->status = $status;
            $model->reviews = $reviews;
            $model->rating = $rating;
            if($request->hasfile('image')){
                $file = $request->file('image');
                $extensions = $file->getClientOriginalExtension();
                $filename = time().'.'.$extensions;
                $file->move('uploads/hotelImages/',$filename);
                $model->image = $filename;
            }
            $model->save();
            return redirect()->route('hotel.index')->with('insert','Record Inserted Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error','Something Went Wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function reviews()
    {
        $model = new Hotel();
        if(auth()->user()->role == 'admin' )
        {
            $record = $model->with('user')->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $record = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
        }
        return view('hotel.review', compact('record')); 

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
    public function hotelstatusupdate($id)
    {
        $model = Hotel::find($id);
        $model->status=!$model->status;
        if($model->save()){
            return redirect()->back()->with('status','Status Updated Successfully');
        }
        else{
            return redirect()->route('hotelstatusupdate');
        }
    }
}
