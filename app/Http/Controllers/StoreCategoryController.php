<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\StoreCategory;
use App\Http\Requests\StoreCategoryStore;
use Exception;

class StoreCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new StoreCategory();
        if(auth()->user()->role == 'admin')
        {
        $records = $model->with('user')->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $records = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
        }
        return view('storecategory.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $helperObject = new Helper();
        $records = $helperObject->users('store');
        return view('storecategory.create', compact('records'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryStore $request)
    {
        try
        {
            $data = $request->validated();
            extract($data);
            $model =  new StoreCategory();
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
            return redirect()->route('storecategory.index')->with('insert','Record Inserted Successfully');
        }
        catch (Exception $e)
        {
            return back()->with('error','Something Went Wrong');
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
        $model = new StoreCategory();
        $record = $model->find($id);
        return view('storecategory.edit', compact('record'));
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
         $model = new StoreCategory();
         $record = $model->find($id);
         $record->name = $name ?? $record->name ;
         $record->save();
         return redirect()->route('storecategory.index')->with('update','Updated Successfully');
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
        $model = new StoreCategory();
        $record = $model->find($id);
        $record->delete();
        return redirect()->route('storecategory.index')->with('delete','Deleted Successfully');

    }
}
