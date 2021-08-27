<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSize;
use DataTables;
use Illuminate\Support\Facades\Validator;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(auth()->user()->hasRole('vendor')){
                $vendor_id = auth()->user()->role;
                $products = Product::where('vendor','=',$vendor_id)->get()->pluck('id');
                $prod_size = ProductSize::whereIn('product_id',$products->toArray())->get();
            }else{
                $prod_size = ProductSize::all();
            }

            return Datatables::of($prod_size)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                    $btn = '';
                    $btn .='<a class="btn btn-info btn-sm" href="sizes/'.$row->id.'/edit">
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
                    ->editColumn('product_id', function($row) {
                        if($row->product == null){
                            return 'Item not exists anymore.';
                        }else{
                            return  $row->product->name;
                        }

                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            $display= array('#','product','size','');
            return view('size.index')
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

        return view('size.create')
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
            'size' => 'required',
        ]);
        if ($validator->fails()) {
            return  redirect()->back()->with('errors', $validator->messages());
        }
        $size = new ProductSize();

        $size->product_id = $request->product_id;
        $size->size = $request->size;

        $size->save();
        return redirect()->back()->with('success', 'new size added.');
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

        $size = ProductSize::find($id);
        return view('size.edit',compact('size','prods'));
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
        $validator = Validator::make($request->all(), [
            'size' => 'required',

        ]);
        if ($validator->fails()) {
            return  redirect()->back()->with('error','Size Field Required');
        }
        $size = ProductSize::find($id);
        $size->update($request->all());

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
