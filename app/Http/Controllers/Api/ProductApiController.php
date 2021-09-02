<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Brand;
use App\Category;
use App\Product;
use App\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $prods = Product::all();
        $products =  array();
        $i = 0;
        foreach($prods as $prod){

            $prodBrand = Brand::where('id','=',$prod->brand)->first();
            $prodSize = $prod->size;
            $prodColor = $prod->color;
            $prodImage = $prod->image;
            $products[$i] = $prod;

            if($prodBrand == null){
                $products[$i]['brand'] = "No Brand";
            }else{
                $products[$i]['brand'] = $prodBrand->name;
            }


            $i++;

        }
        return $products;
    }

    public function getProducts()
    {
        $products =  Product::with('user')->where('available',1)->where('status',1)->get();

        if($products)
        {
            $status = 'True';
            $message = 'Product Find SuccessFully...';
            return response()->json(compact('status','message','products'),201);
        }
        else
        {
            $status = 'False';
            $message = 'Something Went Wrong';
            return response()->json(compact('status','message'),201);
        }

    }

    public function popularProducts()
    {
        $products =  Product::with('images', 'vendor')->with('user')->where('popular',1)->where('available',1)->where('status',1)->get();

        if($products)
        {
            $status = 'True';
            $message = 'Product Find SuccessFully...';
            return response()->json(compact('status','message','products'),201);
        }
        else
        {
            $status = 'False';
            $message = 'Something Went Wrong';
            return response()->json(compact('status','message'),201);
        }
    }
    //deal of the day products
    public function randomProducts(){

        // 10 indicates the number of records
        $prods = Product::inRandomOrder()->limit(10)->get();
        $products =  array();
        $i = 0;
        foreach($prods as $prod){

            $prodBrand = Brand::where('id','=',$prod->brand)->first();
            $prodSize = $prod->size;
            $prodColor = $prod->color;
            $prodImage = $prod->image;
            $products[$i] = $prod;

            if($prodBrand == null){
                $products[$i]['brand'] = "No Brand";
            }else{
                $products[$i]['brand'] = $prodBrand->name;
            }


            $i++;

        }
        return $products;

    }
     // product search
    public function getSingleProduct(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'product_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        $product = Product::with('images')->with('user')->where('available',1)->where('status',1)->findOrFail($request->product_id);

        if($product)
        {
            $status = 'True';
            $message = 'Product Find SuccessFully...';
            return response()->json(compact('status','message','product'),201);
        }
        else
        {
            $status = 'False';
            $message = 'Something Went Wrong';
            return response()->json(compact('status','message'),201);
        }
    }

    //category wise products
    public function categoryWiseProduct(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_id'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        $products = Product::with('images')->with('user')->where('category_id', $request->category_id)->where('available',1)->where('status',1)->get();

        if($products)
        {
            $status = 'True';
            $message = 'Product Find SuccessFully...';
            return response()->json(compact('status','message','products'),201);
        }
        else
        {
            $status = 'False';
            $message = 'Something Went Wrong';
            return response()->json(compact('status','message'),201);
        }
    }

    /**
     * Create a new product
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'category_id'=>'required',
            'brand_id'=>'required',
            'color' => 'required',
            'size' => 'required',
            'price'=>'required',
            'feature_image' => 'required',
            'vendor_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        $product = new Product();
        $product->vendor_id = $request->vendor_id;
        $product->status = 0;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->discount = 0;
        $product->original_price = 0;
        $product->short_desc = $request->short_description;
        $product->status_reason = null;
        $product->color = $request->color;
        $product->size = $request->size;
        if($request->condition)
        {
            $product->condition = $request->condition;
        }


        $product->date = date("Y-m-d");
        $product->available = '1';
        $product->publish = '0';
        $product->seller = '1';
        $product->payment = '0';

        if($request->hasFile('feature_image'))
        {
            $file =  $request->file('feature_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/productImages/',$filename);
            $product->feature_image = $filename ?? $product->feature_image;
        }

        $product->save();

        if($request->hasFile('images'))
        {

            if($request->hasFile('images'))
            {   foreach ($request->file('images') as $image) {


                    $name = time().$image->getClientOriginalName();
                    $path = $image->move('multipleImages/', $name);

                    $images=ProductImage::create([
                        'product_id' => $product->id,
                        'image' => 'multipleImages/'.$name
                    ]);

                      }
            }
        }

        $status = 'True';
        $message = 'Product has been Created SuccessFully.';
        return response()->json(compact('status','message'),201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $prods = Product::where('id','=',$id)->where('available',1)->where('status',1)->get();

        $products =  array();
        $i = 0;

        foreach($prods as $prod){

        $prodBrand = Brand::where('id','=',$prod->brand)->first();
        $prodSize = $prod->size;
        $prodColor = $prod->color;
        $prodImage = $prod->image;
        $products[$i] = $prod;

        if($prodBrand == null){
            $products[$i]['brand'] = "No Brand";
        }else{
            $products[$i]['brand'] = $prodBrand->name;
        }


        $i++;

    }

        return $products;

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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'category_id'=>'required',
            'brand_id'=>'required',
            'color' => 'required',
            'price'=>'required',
            // 'short_description'=>'required',
            'vendor_id' => 'required',
            'product_id' => 'required',
            'size' => 'required',
            'condition' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }


        $product = Product::findOrFail($request->product_id);
        $product->vendor_id = $request->vendor_id;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->short_desc = $request->short_description;
        $product->color = $request->color;
        $product->condition = $request->condition;

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

        $product->save();

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

        $status = 'True';
        $message = 'Product has been Updates SuccessFully.';
        return response()->json(compact('status','message'),201);
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

    public function userProducts()
    {

        $id = auth('api')->user()->id;
        if($id != null) {


            $products = Product::where('vendor', '=', $id)->where('publish', '=', 1)->get();
            if(count($products) > 0 ) {

                $i = 0;
                foreach ($products as $prod) {

                    $prodBrand = Brand::where('id', '=', $prod->brand)->first();
                    $prod->color = $prod->color()->pluck('colour')->implode('colour');
                    $prod->size = $prod->size()->pluck('size')->implode('size');
                    $prod->image = $prod->image()->pluck('image');
                    $products[$i] = $prod;

                    if ($prodBrand == null) {
                        $products[$i]['brand'] = "No Brand";
                    } else {
                        $products[$i]['brand'] = $prodBrand->name;
                    }


                    $i++;

                }
                return $products;
            }else{

                return response()->json(array('status' => false,'message' => 'No Products Found'), 500);
            }
        }else{
            return response()->json(['error','User not logged in']);
        }

    }

    public function filter(Request $request)
    {


        $products =  Product::where('publish','=',1);

        $wishlist = $products->get()->pluck('id');

        $products = Product::whereIn('id',$wishlist)->get();
        $i = 0;
        foreach($products as $prod){

            $prod->brand = Brand::where('id','=',$prod->brand)->first();
            $prod->color = $prod->color()->pluck('colour')->implode('colour');
            $prod->size = $prod->size()->pluck('size')->implode('size');
            $prod->image = $prod->image()->pluck('image');
//            $products[$i] = $prod;

            if($prod->brand == null){
                $prod->brand= "No Brand";
            }else{
                $prod->brand = $prod->brand->name;
            }


            $i++;

        }

        if ($request->has('category_id')) {
            $products->where('cat', $request->category_id);
        }
        if ($request->has('size')) {
            $products->where('size', $request->size);
        }
        if ($request->has('price2')) {
            $products->whereBetween('price', [$request->price1,$request->price2]);
        }

        return $products;
    }

    public function testPayment(Request $request)
    {
                $script = <<< JS

        $(function() {
        // js code goes here
        });

        JS;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://capi.cypheme.com/api/user/verify/tag',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'name=20191014%2F1571060633.8007_91.jpg&openid=xxxefsdf&need_goods_data=1',
            CURLOPT_HTTPHEADER => array(
                'XX-Token: b69ef5931f43ca5b1a228d309c7078dbf2696cbd1069bede23d61242603f5f62',
                'XX-Device-Type: mobile',
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return response()->json($response);
    }

    public function searchProduct(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'search'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        $products = Product::with('images', 'user')
                            ->where('name', 'LIKE',  "%{$request->search}%")
                            ->where('available',1)->where('status',1)->get();

        if(count($products))
        {
            $status = 'True';
            $message = 'Product Find SuccessFully...';
            return response()->json(compact('status','message','products'),201);
        }
        else
        {
            $status = 'False';
            $message = 'There is Not Such Type Of Product Plz Search Correctly..';
            return response()->json(compact('status','message'),201);
        }
    }

    public function searchFilterProduct(Request $request)
    {
// dd($request->all());
        $products = Product::where('status', 1)->where('available',1);

        if (!empty(request('category_id')))
        {
            $products = $products->whereHas('category', function($q) {
                $q->where('category_id', (int)request('category_id'));
            });

        }

        if (!empty(request('brand_id')))
        {
            $products = $products->where(function($query) use($request){
                $query->where('brand_id', (int)$request->brand_id);
            });
        }

        if (!empty(request('size')))
        {
            $products = $products->where('size', $request->size);
        }

        if (!empty(request('color')))
        {
            $products = $products->where('color', $request->color);
        }


        if (!empty(request('max_price')))
        {
                    if (!empty(request('min_price'))){
           $min=(int)$request->min_price;

                    }
                    else
                    {
                     $min=(int)0;

                    }
            $max=(int)$request->max_price;

            $products = $products->whereBetween('price', [$min, $max]);


        }

        $products = $products->with('images', 'vendor')->get();

        if(count($products))
        {
            $status = 'True';
            $message = 'Product Find SuccessFully...';
            return response()->json(compact('status','message','products'),201);
        }
        else
        {
            $status = 'False';
            $message = 'No Product Found';
            return response()->json(compact('status','message'),201);
        }
    }
}
