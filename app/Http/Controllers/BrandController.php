<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;
use DataTables;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new Brand();
        $records = $model->latest()->paginate(config('app.pagination_length'));
        $display= array('#','name','picture','description','created_at','Action');
        return view('brand.index')
            ->with('records',$records)
            ->with('display',$display);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return  redirect()->back()->with('errors', $validator->messages());
        }
        $brand = new Brand();

        $brand->name = $request->name;
        $brand->description = $request->description;

        if($request->hasFile('picture'))
        {
            // if(file_exists(public_path('uploads/categoryImages'.$category->picture))){
            //     @unlink('uploads/categoryImages'.$category->picture);
            // }
            $file =  $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/brandImages/',$filename);
            $brand->picture = $filename ?? $brand->picture;
        }

        $brand->save();

        return redirect()->route('brands.index')->with('insert', 'New brand Added SuccessFully..');
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
       $brand = Brand::find($id);
//       return view('brand.edit',compact('brands'));
       return view('brand.edit',compact('brand'));
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
        // dd($request->all());
        $brand = Brand::find($id);

        if($request->name)
        {
            $brand->name = $request->name;
        }
        if($request->description)
        {
            $brand->description = $request->description;
        }

        if($request->hasFile('picture'))
        {
            if(file_exists(public_path('uploads/brandImages/'.$brand->picture))){
                @unlink('uploads/brandImages/'.$brand->picture);
            }
            $file =  $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/brandImages/',$filename);
            $brand->picture = $filename ?? $brand->picture;
        }

        $brand->update();

        return redirect()->route('brands.index')->with('update', 'Brand Updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if($brand->picture)
        {
            if(file_exists(public_path('uploads/brandImages/'.$brand->picture))){
                @unlink('uploads/brandImages/'.$brand->picture);
            }
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('delete', 'Brand Deleted SuccessFully..');
    }
}
