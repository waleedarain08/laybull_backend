<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{GroceryProduct,GroceryCategory,User,GroceryVendorReviews,GroceryProductReviews};
use App\Helpers\Helper;
use Exception;

class GroceryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new GroceryProduct();
        if(auth()->user()->role == 'admin')
        {
            $records = $model->with('user')->latest()->paginate(config('app.pagination_length'));
            $grocercategory = GroceryCategory::get();
        }
        else if(auth()->user()->role == 'vendor')
        {
            $records = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
            $grocercategory = GroceryCategory::get();
        }
            return view('groceryproduct.index', compact('records','grocercategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $grocercategory = GroceryCategory::get();
        $helperObject = new Helper();
        $userrecords = $helperObject->users('grocery');
        return view('groceryproduct.create', compact('grocercategory','userrecords'));
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
            $model = new GroceryProduct();
            $model->grocery_category_id = $grocerycategory;
            if(auth()->user()->role == 'admin')
            {
                $model->vendor_id = $request->vendor;
            }
            else
            {
                $model->vendor_id = auth()->user()->id;
            }
            $model->name = $name ;
            $model->quantity = $quantity;
            $model->price = $price;
            $model->status = $status;
            if($request->hasfile('image'))
            {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/groceryproduct/',$filename);
                $model->image = $filename; 
            }
            else
            {
                
                $model->Image = '';
            }
            $model->save();
            return redirect()->route('groceryproduct.index')->with('insert','Record Inserted Successfully');
            
        } 
        catch (Exception $e) 
        {
            return redirect()->back('error','Something Went Wrong');
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
        $modelcategory = new GroceryCategory();
        if(auth()->user()->role == 'admin')
        {
            $groceryCategories = $modelcategory->get();
        }
        elseif(auth()->user()->role == 'vendor')
        {
        $groceryCategories = $modelcategory->where('vendor_id',auth()->user()->id)->get();
        }

        $model = new GroceryProduct();
        $record = $model->find($id);
       
        return view('groceryproduct.edit', compact(['record','groceryCategories']));
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
            // print_r($request->all());
            // exit;
           $data =  $request->all();
           extract($data);
           $model = new GroceryProduct();
           $record = $model->find($id);
           $record->grocery_category_id  = $grocerycategory;
           $record->vendor_id = auth()->user()->id;
           $record->name = $name;
           $record->quantity = $quantity;
           $record->price = $price;
           if($request->hasfile('photo'))
           {
            $file =  $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/groceryproduct/',$filename);
            $record->image = $filename ?? $record->image;
            }
            $record->save();
            return redirect()->route('groceryproduct.index')->with('update','Updated Successfully');
        }
        catch(Exception $e)
        {
            return redirect()->back()->with('error','Something Went Wrong');
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
        $model = new GroceryProduct();
        $record = $model->find($id);
        $record->delete();
        return redirect()->route('groceryproduct.index')->with('delete','Deleted Successfully');
    }
    public function reivew()
    {
        $model = new GroceryProductReviews();
        if(auth()->user()->role == 'admin')
        {
            $record = $model->with('groceryproduct.user')->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $record = $model->whereHas('groceryproduct',function($q){
                $q->where('vendor_id',auth()->user()->id)->with('user');
            })->latest()->paginate(config('app.pagination_length'));
        }
        
        return view('groceryproduct.groceryProductReviews', compact('record'));
    }

    public function vendorreivew()
    {
        $model = new GroceryVendorReviews();
        if(auth()->user()->role == 'admin')
        {
            $record = $model->with('vendor')->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $record = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
        }
        
        return view('groceryproduct.groceryVendorReviews', compact('record'));
    }
    public function updategrocerystatus($id)
    {
        $model = GroceryProduct::find($id);
        $model->status = !$model->status;
        if($model->save())
        {
            return redirect()->back()->with('status','Status Updated Successfully');
        }
        else
        {
            return redirect()->route('updategrocerystatus');
        }
    }
}
