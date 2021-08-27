<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{GroceryCategory,User};
use App\Helpers\Helper;
use App\Http\Requests\GroceryStore;
use Exception;

class GroceryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new GroceryCategory();
        if(auth()->user()->role == 'admin')
        {
           $records = $model->with('user')->latest()->paginate(config('app.pagination_length'));
        }
        else if(auth()->user()->role == 'vendor')
        {
            $records = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
        }
        return view('grocerycategory.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $helperObject = new Helper();
        $records = $helperObject->users('grocery');
        return view('grocerycategory.create', compact('records'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroceryStore $request)
    {
        try 
        {
            $data = $request->validated();
            extract($data);
            $model = new GroceryCategory();
            $model->name = $name;
            if(auth()->user()->role == 'admin')
            {
                $model->vendor_id = $request->vendor;
            }
            elseif(auth()->user()->role == 'vendor')
            {
                $model->vendor_id = auth()->user()->id;
            }
            $model->save();
            return redirect()->route('grocerycategory.index')->with('insert','Record Inserted Successfully');
        } 
        catch (Exception $e) 
        {
            return redirect()->back()->with('insert','Record Inserted Successfully');
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
        $model = new GroceryCategory();
        $record = $model->find($id);
       return view('grocerycategory.edit', compact('record'));
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
       try
       {
        $data = $request->all();
        extract($data); 
        $model = new GroceryCategory();
        $record = $model->find($id);
        $record->name = $name ?? $record->name ;
        $record->save();
        return redirect()->route('grocerycategory.index')->with('update','Updated Successfully');
       } 
       catch (Exception $e)
       {
           
        return redirect()->back()->with('insert','Record Inserted Successfully');
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = new GroceryCategory();
        $record = $model->find($id);
        $record->delete();
        return redirect()->route('grocerycategory.index')->with('delete','Deleted Successfully');
    }
}
