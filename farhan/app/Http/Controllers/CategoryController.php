<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;
use DataTables;
use Defuse\Crypto\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd("Usman");
        $model = new Category();
        $records = $model->where('parent','=',0)->latest()->paginate(config('app.pagination_length'));
        $display= array('#','name','picture','created_at','Actions','');

        return view('category.index')
                                ->with('display',$display)
                                ->with('records',$records);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Category::all(['id', 'name']);
        return view('category.create')
                ->with('cats',$cats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;

        if($request->hasfile('picture')){
            $file =  $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/categoryImages/',$filename);
            $category->picture = $filename ?? $category->picture;
        }

        $category->save();

        return redirect()->route('categories.index')->with('insert', 'New Category Added SuccessFully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cats = Category::all();
        $category = Category::where('id',$id)->first();
        return view('category.show')
                ->with('cats',$cats)
                ->with('category',$category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::where('id',$id)->first();
        $cats = Category::all();
        return view('category.edit')
                ->with('cats',$cats)
                ->with('category',$category);
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
        //dd($request->all());
        $category = Category::findOrFail($id);

        if($request->name)
        {
            $category->name = $request->name;
        }
        if($request->parent)
        {
            $category->parent = $request->parent;
        }
        if($request->easy_commission == "")
        {
            $easy_commission = 0;
        }
        else
        {
            $easy_commission = $request->easy_commission;
        }
        if($request->top_menu)
        {
            $category->top_menu = $request->top_menu;
        }

        if($request->hasFile('picture'))
        {
            if(file_exists(public_path('uploads/categoryImages/'.$category->picture))){
                @unlink('uploads/categoryImages/'.$category->picture);
            }
            $file =  $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/categoryImages/',$filename);
            $category->picture = $filename ?? $category->picture;
        }

        $category->update();

        return redirect()->route('categories.index')->with('update', 'Category Updated SuccessFully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category->picture)
        {
            if(file_exists(public_path('uploads/categoryImages/'.$category->picture))){
                @unlink('uploads/categoryImages/'.$category->picture);
            }
        }

        $category->delete();

        return redirect()->route('categories.index')->with('delete', 'Category Deleted SuccessFully..');
    }


}
