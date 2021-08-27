<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{StoreCategory,StoreProduct,StoreProductReviews,StoreVendorReviews};
use App\Helpers\Helper;
use Exception;

class StoreProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new StoreProduct;
        if(auth()->user()->role == 'admin')
        {
            $records = $model->with('user')->latest()->paginate(config('app.pagination_length'));  
            $modelcategory =StoreCategory::get();
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $records = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));  
            $modelcategory =StoreCategory::get();   
        }
        return view('storeproduct.index', compact('modelcategory','records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model =  new StoreCategory();
        $record = $model->get();
        $helperObject = new Helper();
        $userrecords = $helperObject->users('store');
        return view('storeproduct.create', compact('record','userrecords'));
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
            $model = new StoreProduct();
            $model->store_category_id = $storecategory;
            $model->vendor_id = auth()->user()->id;
            $model->name = $name;
            $model->quantity = $quantity;
            $model->price = $price;
            $model->status =$status;
            if($request->hasfile('image')){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/storeproductimage/',$filename);
                $model->image = $filename;
            }
            else
            {
              $model->image = ' ';   
            }
            $model->save();
            return redirect()->route('storeproduct.index')->with('insert','Record Inserted Successfully');
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
       $modelcategory = new StoreCategory();
       if(auth()->user()->role == 'admin')
       {
        $storeCategories = $modelcategory->get();
       }
       elseif(auth()->user()->role == 'vendor')
        {
           $storeCategories = $modelcategory->where('vendor_id',auth()->user()->id)->get();
        }
        $model = new StoreProduct();
        $record = $model->find($id);
        return view('storeproduct.edit', compact(['record','storeCategories']));
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
           $data =  $request->all();
           extract($data);
           $model = new StoreProduct();
           $record = $model->find($id);
           $record->store_category_id = $storecategory;
           $record->vendor_id = auth()->user()->id;
           $record->name = $name;
           $record->quantity = $quantity;
           $record->price = $price;
           if($request->hasfile('photo')){
            $file =  $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/storeproductimage/',$filename);
            $record->image = $filename ?? $record->image;
        }
        $record->save();
        return redirect()->route('storeproduct.index')->with('update','Updated Successfully');

        }catch(Exception $e)
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
        $model = new StoreProduct();
        $record = $model->find($id);
        $record->delete();
        return redirect()->route('storeproduct.index')->with('delete','Deleted Successfully');

    }
    public function reivew()
    {
        $model = new StoreProductReviews();
        if(auth()->user()->role == 'admin')
        {
            $record = $model->with('storeproduct.user')->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $record = $model->whereHas('storeproduct',function($q){
                $q->where('vendor_id',auth()->user()->id)->with('user');
            })->latest()->paginate(config('app.pagination_length'));
        }
        
        return view('storeproduct.storeProductReviews', compact('record'));
    }

    public function vendorreivew()
    {
        $model = new StoreVendorReviews();
        if(auth()->user()->role == 'admin')
        {
            $record = $model->with('vendor')->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $record = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
        }
        
        return view('storeproduct.storeVendorReviews', compact('record'));
    }

    public function updatestoreproductstatus($id)
    {
        $model =StoreProduct::find($id);
        $model->status=!$model->status;
        if($model->save()){
            return redirect()->back()->with('status','Status Updated Successfully');
        }
        else{
            return redirect()->route('updatestoreproductstatus');
        } 
    }
}
