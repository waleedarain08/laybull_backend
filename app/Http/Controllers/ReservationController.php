<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationStore;
use App\{Reservation,User};

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new Reservation();
        if(auth()->user()->role == 'admin')
        {
            $records = $model->with('vendor')->latest()->paginate(config('app.pagination_length'));  
        }
        elseif(auth()->user()->role == 'vendor')
        {
          $records =$model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));    
        }
        return view('foodReservation.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new User();
        $record = $model->where('reservation',1)->get();
        return view('foodReservation.create', compact('record'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationStore $request)
    {
        
        // print_r($request);
        // exit;
        try 
        {
            $data = $request->all();
            extract($data);
            $model = new Reservation();
            if(auth()->user()->role == 'admin')
            {
                $model->vendor_id = $request->vendor;
            }
            elseif(auth()->user()->role == 'vendor')
            {
                $model->vendor_id = auth()->user()->id;            
            }
            $model->name=$name;
            $model->time=$time;
            $model->price=$price;
            $model->person=$person;
            $model->save();


            return redirect()->route('reservation.index')->with('insert','Insert Record Successfully');
        } 
        catch (Exception $e)
        {   
           
            return redirect()->back()->with('error','something went wrong'); 
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
}
