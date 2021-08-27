<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{FoodCategory,User};
use App\Helpers\Helper;
use App\Http\Requests\FoodCategoryStore;
use Exception;

class FoodCategoryController extends Controller
{    
    public function index()
    {        
        $model = new FoodCategory();
        if(auth()->user()->role == 'admin')
        { 
            $records = $model->with('user')->latest()->paginate(config('app.pagination_length'));
            
        }
        else if(auth()->user()->role == 'vendor')
        {
            $records = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
        }
        return view('FoodCategory.index', compact('records'));
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $helperObject = new Helper();
        $records = $helperObject->users('food');
        return view('FoodCategory.create',compact('records'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodCategoryStore $request)
    {
        try 
        {
            $data = $request->validated();
            extract($data);
            $foodcatgroy = new FoodCategory();
            $foodcatgroy->name = $name;
            if(auth()->user()->role == 'admin')
            {
                
                $foodcatgroy->vendor_id = $request->vendor;
            }
            elseif(auth()->user()->role == 'vendor')
            {
                $foodcatgroy->vendor_id = auth()->user()->id;
            }
            $foodcatgroy->save();
            return redirect()->route('foodcategory.index')->with('insert','Inserted Successfully');
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
        $model = new FoodCategory();
        $record = $model->find($id);
       return view('FoodCategory.edit', compact('record'));
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
        // print_r($request->toArray());
        // exit;
       try
       {
           $data = $request->all();
           extract($data);
        $model = new FoodCategory();
        $record = $model->find($id);
        $record->name = $name ?? $record->name;
        $record->save();
        return redirect()->route('foodcategory.index')->with('update','Updated Successfully');
       }
       catch (Exception $e) {
           print_r($e->getMessage());
           exit;
           return redirect()->back();
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
        $model = new FoodCategory();
        $record = $model->find($id);
        $record->delete();
        
        // print_r($record->toArray());
        // exit;
        return redirect()->route('foodcategory.index')->with('delete','Deleted Successfully');

    }
}
