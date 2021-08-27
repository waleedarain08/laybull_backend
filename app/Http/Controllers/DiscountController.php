<?php

namespace App\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new Discount();
        $records = $model->latest()->paginate(config('app.pagination_length'));
        $display= array('#', 'Coupon Name', 'Discount Percentage', 'Action');
        return view('discount.index')
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
        $user = auth()->user();
        return view('discount.create');
      }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $discount = new Discount();
        $discount->coupon_name = $request->coupon_name;
        $discount->discount_percent = $request->discount_percent;
        $discount->save();
        return redirect()->route('discounts.index')->with('update', 'Discount Created SuccessFully..');

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
        $discount = Discount::where('id',$id)->first();
        return view('discount.edit')->with('discount',$discount);
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
                $country = Discount::findOrFail($id);
                $country->coupon_name = $request->coupon_name;
                $country->discount_percent = $request->discount_percent;
                $country->save();
                return redirect()->route('discounts.index')->with('update', 'Discount Updated SuccessFully..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discount = Discount::find($id);
        $discount->delete();

        return redirect()->route('discounts.index')->with('delete', 'Discount Deleted SuccessFully..');

    }
    public function verify_coupon(Request $request)
    {
           $validator = Validator::make($request->all(),[
            'coupon_name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        $coupon = Discount::where('coupon_name',$request->coupon_name)->first();

        if($coupon)
        {
            $status = 'True';
            $message = 'Product Coupon  Found...';
            return response()->json(compact('status','message','coupon'),201);
        }
        else
        {
            $status = 'False';
            $message = 'Something Went Wrong';
            return response()->json(compact('status','message'),201);
        }
    

    }
}
