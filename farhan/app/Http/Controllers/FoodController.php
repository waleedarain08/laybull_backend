<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Food,FoodCategory, User,FoodProductReviews,FoodVendorReviews};
use App\Helpers\Helper;
use Exception;
use PHPUnit\TextUI\Help;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new Food();
        if(auth()->user()->role == 'admin')
        {
            $records = $model->with('user')->latest()->paginate(config('app.pagination_length'));
            $foodcategorymodel = new FoodCategory();
            $foodcategoryrecord = $foodcategorymodel->get();
            
        }
        else
        {

            $records = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
            $foodcategorymodel = new FoodCategory();
            $foodcategoryrecord = $foodcategorymodel->get();
        }
       
        return view('Food.index', compact('records','foodcategoryrecord'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new FoodCategory();
        $record = $model->latest()->get();
       
        $helperObject = new Helper();
        $userrecords = $helperObject->users('food');
        return view('Food.create', compact('record','userrecords') );
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
            $model = new Food();
            $model->food_category_id=$foodcategory;
            if(auth()->user()->role == 'admin')
            {
                $model->vendor_id = $request->vendor;
            }
            elseif(auth()->user()->role == 'vendor')
            {
                $model->vendor_id = auth()->user()->id;            
            }
            $model->name=$name;
            $model->quantity=$quantity;
            $model->price=$price;
            $model->status=$status;
        if($request->hasfile('image'))
            {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/images/',$filename);
                $model->image =$filename;
            }
            else
            {
                
                $model->Image = '';
            }
            $model->save();
            return redirect()->route('food.index')->with('insert','Inserted Successfully');

        } 
        catch (Exception $e) 
        {
           print_r($e->getMessage());exit;
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
        $modelcategory = new FoodCategory();
        if(auth()->user()->role == 'admin')
        {

            $foodCategories = $modelcategory->get();
        }
        elseif(auth()->user()->role == 'vendor')
        {
            
            $foodCategories = $modelcategory->where('vendor_id',auth()->user()->id)->get();
        }

        $model = new Food();
        $record = $model->find($id);
       
        return view('Food.edit', compact(['record','foodCategories']));
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
           $model = new Food();
           $record = $model->find($id);
           $record->food_category_id = $foodcategory;
           $record->vendor_id = auth()->user()->id;
           $record->name = $name;
           $record->quantity = $quantity;
           $record->price = $price;
           if($request->hasfile('photo')){
            $file =  $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/images/',$filename);
            $record->image = $filename ?? $record->image;
        }
        $record->save();
        return redirect()->route('food.index')->with('update','Updated Successfully');

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

        $model = new Food();
        $record = $model->find($id);
        $record->delete();
        return redirect()->route('food.index')->with('delete','delete','Deleted Successfully');
    }
    public function reivew()
    {
        $model = new FoodProductReviews();
        if(auth()->user()->role == 'admin')
        {
            $record = $model->with('foodProduct.user')->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $record = $model->whereHas('foodProduct',function($q){
                $q->where('vendor_id',auth()->user()->id)->with('user');
            })->latest()->paginate(config('app.pagination_length'));
        }
        
        return view('Food.foodProductReviews', compact('record'));
    }

    public function vendorreivew()
    {
        $model = new FoodVendorReviews();
        if(auth()->user()->role == 'admin')
        {
            $record = $model->with('vendor')->latest()->paginate(config('app.pagination_length'));
        }
        elseif(auth()->user()->role == 'vendor')
        {
            $record = $model->where('vendor_id',auth()->user()->id)->latest()->paginate(config('app.pagination_length'));
        }
        
        return view('Food.foodVendorReviews', compact('record'));
    }

    public function updatefoodstatus($id)
    {
        $model = Food::find($id);
        $model->status = !$model->status;
        if($model->save())
        {
            return redirect()->back()->with('status','Status Updated Successfully');
        }
        else
        {
            return redirect()->route('updatefoodstatus');
        }

    }
}
