<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Cars,ShowRoom};
use App\Helpers\Helper;
use Exception;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $model = new Cars();
        if(auth()->user()->role == 'admin')
        {
            $carrecords = $model->with('user')->latest()->paginate(config('app.pagination_length'));
            $showroom =ShowRoom::get();
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $carrecords = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
            $showroom =ShowRoom::get();
        }
        return view('cars.index', compact('carrecords','showroom'));
    }
    public function review()
    {   
        if(auth()->user()->role == 'admin')
        {
            $records = Cars::with('user')->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $records = Cars::where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
        }
        return view('cars.review', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new ShowRoom();
        $records = $model->get();
        $helperObject = new Helper();
        $userrecords = $helperObject->users('car');
        return view('cars.create', compact('records','userrecords'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try 
        {
            $data = $request->all();
            extract($data);
            $model = new Cars();
            $model->showroom_id =$showroomcategory;
            $model->name = $name;
            $model->description = $description;
            $model->price = $price;
            $model->status = $status;
            $model->review = $review;
            $model->rating = $rating;
            if(auth()->user()->role == 'admin')
            {
                $model->vendor_id = $request->vendor;
            }
            elseif(auth()->user()->role == 'vendor')
            {
                $model->vendor_id = auth()->user()->id;
            }

            if($request->hasfile('image'))
            {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/carsImage/',$filename);
                $model->image = $filename;  
            }
            $model->save();
            return  redirect()->route('cars.index')->with('insert','Records Inserted Successfully');
        }
        catch (Exception $e) 
        {
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
    public function statusupdatecars($id)
    {
        $model = Cars::find($id);
        $model->status = !$model->status;
        if($model->save())
        {
            return redirect()->back()->with('status','Status Updated Successfully');
        }
        else
        {
            return redirect()->route('statusupdatecars');
        }
    }
}
