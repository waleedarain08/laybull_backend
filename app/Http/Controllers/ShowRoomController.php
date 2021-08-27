<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\ShowRoom;
use Exception;

class ShowRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new ShowRoom();
        if(auth()->user()->role == 'admin')
        {
            $records = $model->with('user')->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $records = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
        }
       
        return view('showroom.index', compact('records'));

    }
    public function review()
    {
        $model = new ShowRoom();
        if(auth()->user()->role =='admin')
        {
            $records = $model->with('user')->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $records = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));

        }
       
        return view('showroom.review', compact('records'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $helperObject = new Helper();
        $userrecords = $helperObject->users('car');
        return view('showroom.create', compact('userrecords') );
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
            $data = $request->all();
            extract($data);
            $model = new ShowRoom();
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
            $model->status = $status;
            $model->reviews = $reviews;
            $model->rating = $rating;
            if($request->hasfile('image')){

                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/showroomImages/',$filename);
                $model->image = $filename; 

            }
             $model->save();
          
            return redirect()->route('showroom.index')->with('insert','Records Inserted Successfully');
        }
        catch (Exception $e)
        {
            return redirect()->back()->with('error','Something Went wrong');
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
    public function showroomstatus($id)
    {
        $model = ShowRoom::find($id);
        $model->status = !$model->status;
        if($model->save()){
            return redirect()->back()->with('status','Status Update Successfully');
        }
        else{
            return redirect()->route('showroomstatus');

        }
    }
}
