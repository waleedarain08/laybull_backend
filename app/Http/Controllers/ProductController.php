<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;
use App\ProductImage;
use DataTables;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new Product();
        $records = $model->latest()->paginate(config('app.pagination_length'));
            $display= array('#', 'Name', 'Feature Image', 'Category', 'Seller', 'Price', 'Popular', 'Status', 'Action');
            return view('product.index')
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
        $brands = Brand::all();
        $cats = Category::all();
        $user = auth()->user();
        return view('product.create')
                ->with('cats',$cats)
                ->with('brands',$brands);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $product = new Product();
        $product->vendor_id = $request->vendor;
        $product->status = 0;
        $product->name = $request->name;
        $product->category_id = $request->cat_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->short_desc = $request->short_desc;
        $product->color = $request->color;
        $product->size = $request->size;
        $product->condition = $request->condition;
        if($request->popular)
        {
            $product->popular = $request->popular;
        }

        if($request->hasFile('feature_image'))
        {
            $file =  $request->file('feature_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/productImages/',$filename);
            $product->feature_image = $filename ?? $product->feature_image;
        }

        $product->detail = "";
        $product->date = date("Y-m-d");
        $product->available = '1';
        $product->publish = '1';
        $product->seller = '1';
        $product->payment = '0';
        $product->warrenty = '0';

        $product->save();


        if($request->hasFile('images'))
        {
            foreach ($request->file('images') as $image) {

                $name = time().$image->getClientOriginalName();
                $path = $image->move(public_path().'/multipleImages/', $name);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'multipleImages/'.$name
                ]);
            }
        }

        return redirect()->route('products.index')->with('insert', 'New Product Added SuccessFully...');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id',$id)->first();
        return view('product.show')
                ->with('product',$product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where('id',$id)->first();
        $cats = Category::all();
        $brands = Brand::all();
        $user = auth()->user();
        $vendor_id = $user->role;
        $vendor_name = $user->name;
        return view('product.edit')
                ->with('product',$product)
                ->with('cats',$cats)
                ->with('vendor_id',$vendor_id)
                ->with('vendor_name',$vendor_name)
                ->with('brands',$brands);
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
        $product = Product::findOrFail($id);

        $product->name = $request->name;
        $product->category_id = $request->cat_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->original_price = $request->original_price;
        $product->short_desc = $request->short_desc;
        $product->color = $request->color;
        $product->size = $request->size;
        if($request->condition)
        {
            $product->condition = $request->condition;
        }
        if($request->popular)
        {
            $product->popular = $request->popular;
        }

        if($request->hasFile('feature_image'))
        {
            if(file_exists(public_path('uploads/productImages/'.$product->feature_image))){
                @unlink('uploads/productImages/'.$product->feature_image);
            }
            $file =  $request->file('feature_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/productImages/',$filename);
            $product->feature_image = $filename ?? $product->feature_image;
        }

        $product->update();

        if($request->hasFile('images'))
        {
            if($product->images)
            {
                for($j = 0;$j < count($product->images); $j++)
                {
                    if(file_exists(public_path($product->images[$j]->image))){
                        @unlink($product->images[$j]->image);
                    }
                }
            }

            ProductImage::where('product_id', $product->id)->delete();

            if($request->hasFile('images'))
            {
                foreach ($request->file('images') as $image) {

                    $name = time().$image->getClientOriginalName();
                    $path = $image->move(public_path().'/multipleImages/', $name);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => 'multipleImages/'.$name
                    ]);
                }
            }
        }


        return redirect()->route('products.index')->with('update', 'Product Updated SuccessFully..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product = Product::find($id);

        if($product->images)
        {
            for($j = 0;$j < count($product->images); $j++)
            {
                if(file_exists(public_path('storage/'.$product->images[$j]->image))){
                    @unlink('storage/'.$product->images[$j]->image);
                }
            }
        }

        if(file_exists(public_path('uploads/productImages/'.$product->feature_image))){
            @unlink('uploads/productImages/'.$product->feature_image);
        }

        ProductImage::where('product_id', $id)->delete();

        $product->delete();

        return redirect()->route('products.index')->with('delete', 'Product Deleted SuccessFully..');
    }
    public function delete($id)
    {
        Product::find($id)->delete();

        return redirect('products.index')->with('success', 'product deleted.');
    }

    public function approve($id)
    {
        $product = Product::find($id);
        $product->status = 1;
        $product->update();

        return redirect()->route('products.index')->with('update', 'Product Approved SuccessFully..');
    }

    public function reject(Request $request)
    {
        $product = Product::find($request->id);
        $product->status_reason = $request->reason;
        $product->status = 0;
        $product->update();

        return redirect()->route('products.index')->with('delete', 'Product Rejected SuccessFullt');
    }
}
