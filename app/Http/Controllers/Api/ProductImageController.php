<?php

namespace App\Http\Controllers;

use App\ProductSize;
use Illuminate\Http\Request;
use App\Product;
use App\ProductImage;
use App\Category;
use App\Brand;
use DataTables;
use Illuminate\Support\Facades\Validator;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {            if(auth()->user()->hasRole('vendor')){
            $vendor_id = auth()->user()->role;
            $products = Product::where('vendor','=',$vendor_id)->get()->pluck('id');
            $prod_image = ProductImage::whereIn('product_id',$products->toArray())->get();
        }else{
            $prod_image = ProductImage::all();
        }
            return Datatables::of($prod_image)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn= '';
                    //     $btn = '<a class="btn btn-primary btn-sm" href="/images/'.$row->id.'">
                    //     <i class="fas fa-eye">
                    //     </i>
                    //     View
                    // </a>';
                    $btn .= '<a class="btn btn-info btn-sm" href="images/'.$row->id.'/edit">
                        <i class="fas fa-pencil-alt">
                        </i>
                        Edit
                    </a>';
                    // <form method="post" action="{{ route(post.destroy), $row->id }}">
                    //     {{ csrf_field() }}
                    //     {{ method_field("DELETE") }}

                        $btn.='<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
                    // </form>

                        return $btn;
                    })
                ->editColumn('image', function($row) {
                    if($row->image != 'none'){
                        $url=  '<img src="public/'.$row->image.'" alt="" width="100" height="100">';

                    } else{
                        $url ='No-Image';
                    }
                    return  $url;

                })
                ->editColumn('colour', function($row) {
                    if($row->colour != 'none'){
                        $url=  '<div style="background-color:'.$row->colour.'; height:20px;width:20px;"></div> ';

                    } else{
                        $url ='No-Color';
                    }
                    return  $url;

                })
                    ->editColumn('product_id', function($row) {
                        if($row->product == null){
                            return 'Item not exists anymore.';
                        }else{
                            return  $row->product->name;
                        }

                    })
                    ->rawColumns(['action','image','colour'])
                    ->make(true);
            }
            $display= array('#','product name','image','color','');
            return view('image.index')
                ->with('display',$display);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendor_id = auth()->user()->role;
        $prods = Product::where('vendor',$vendor_id)->get();
        return view('image.create')
                ->with('prods',$prods);
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
            'product_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return  redirect()->back()->with('errors', $validator->messages());
        }
        $variant = new ProductImage();

        $variant->product_id = $request->product_id;

        if($request->colour == ""){
            $variant->colour = '';
        }else{
            $variant->colour = $request->colour;
        }


        if($request->hasFile('image'))
            {
            $file = $request->image;
            $imageName = $file->getClientOriginalName();
            $file->move(public_path('img_product/'), $imageName);
            $variant->image = 'img_product/'.$imageName;

            }


        $variant->save();
        return redirect()->back()->with('success', 'new variant added.');
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
        $vendor_id = auth()->user()->role;
        $prods = Product::where('vendor',$vendor_id)->get();
        $image = ProductImage::find($id);
        return view('image.edit',compact('image','prods'));
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

        $image = ProductImage::find($id);

        if($request->hasFile('image'))
        {
            $file = $request->image;
            $imageName = $file->getClientOriginalName();

            $file->move(public_path('img_product/'), $imageName);
            $picture = 'img_product/'.$imageName;

        }
        $request->image = $picture;

        $image->update(['product_id' => $request->product_id,'colour' => $request->colour,
            'image' => $picture,]);
        return redirect()->back();

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
}
