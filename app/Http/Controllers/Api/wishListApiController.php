<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Brand;
use App\Wishlist;
use Illuminate\Support\Facades\Validator;

class wishListApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function getWishlist()
    {
//        $validator = Validator::make($request->all(), [
//            'cust_id' => 'required',
//        ]);
//
//        if ($validator->fails()) {
//            return  response()->json(array('status' => false, 'message' => $validator->messages()), 500);
//        }
        try{

        $wishlist = Wishlist::where('user_id','=',auth('api')->user()->id)->get()->pluck('prod_id');


        if(count($wishlist) > 0){
            $products = array();
            $i = 0;
            $pro = Product::whereIn('id',$wishlist)->get();

            foreach ($pro as $prod) {

                $prodBrand = Brand::where('id', '=', $prod->brand)->first();

                $products[$i] = $prod;
                $prod->color = $prod->color()->pluck('colour')->implode('colour');
                $prod->size = $prod->size()->pluck('size')->implode('size');
                $prod->image = $prod->image()->pluck('image');

                if ($prodBrand == null) {
                    $products[$i]['brand'] = "No Brand";
                } else {
                    $products[$i]['brand'] = $prodBrand->name;
                }


                $i++;

            }
            return response()->json(array('status' => true,'wishlist' => $products), 200);
        }else{
            return response()->json(array('status' => false,'message' => 'no wishlist found.'), 200);
        }
        }catch (\Exception $e){
            return response()->json(array('error'=>'something went wrong','message'=> $e->getMessage()));
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'prod_id' => 'required',
        ]);

        if ($validator->fails()) {
            return  response()->json(array('status' => false, 'message' => $validator->messages()), 500);
        }
        if(!Wishlist::where('user_id',auth('api')->user()->id)->where('prod_id',$request->prod_id)->exists()){
            $wishlist =  new Wishlist();
            $wishlist->user_id = auth('api')->user()->id;
            $wishlist->prod_id = $request->prod_id;
            $wishlist->save();
            $userWishlist = Wishlist::where('user_id','=',auth('api')->user()->id)->get()->pluck('prod_id');

            $products = array();
            $i = 0;
            $pro = Product::whereIn('id',$userWishlist)->get();

            foreach ($pro as $prod) {

                $prodBrand = Brand::where('id', '=', $prod->brand)->first();

                $products[$i] = $prod;
                $prod->color = $prod->color()->pluck('colour')->implode('colour');
                $prod->size = $prod->size()->pluck('size')->implode('size');
                $prod->image = $prod->image()->pluck('image');

                if ($prodBrand == null) {
                    $products[$i]['brand'] = "No Brand";
                } else {
                    $products[$i]['brand'] = $prodBrand->name;
                }


                $i++;

            }
            $userWishlist = $products;

        }else{
            $wish = Wishlist::where('user_id',auth('api')->user()->id)->where('prod_id',$request->prod_id)->first();
            Wishlist::find($wish->id)->delete();
            if(count(Wishlist::where('user_id','=',auth('api')->user()->id)->get()) > 0){
               $userWishlist= Wishlist::where('user_id','=',auth('api')->user()->id)->get()->pluck('prod_id');

                $products = array();
                $i = 0;
                $pro = Product::whereIn('id',$userWishlist)->get();

                foreach ($pro as $prod) {

                    $prodBrand = Brand::where('id', '=', $prod->brand)->first();

                    $products[$i] = $prod;
                    $prod->color = $prod->color()->pluck('colour')->implode('colour');
                    $prod->size = $prod->size()->pluck('size')->implode('size');
                    $prod->image = $prod->image()->pluck('image');

                    if ($prodBrand == null) {
                        $products[$i]['brand'] = "No Brand";
                    } else {
                        $products[$i]['brand'] = $prodBrand->name;
                    }


                    $i++;

                }
                $userWishlist = $products;

            }else{
                $userWishlist= 'Your Wishlist is empty!';
            }
        }



         return response()->json(array('status' => true,'message' => 'wishlist saved.','records'=>$userWishlist), 200);
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
        //
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
        //
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
    public function deleteWishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cust_id' => 'required',
            'prod_id' => 'required',
        ]);

        if ($validator->fails()) {
            return  response()->json(array('status' => false, 'message' => $validator->messages()), 500);
        }
        $wishlist = Wishlist::where('cust_id',$request->cust_id)
                    ->where('prod_id',$request->prod_id)
                    ->delete();
        if($wishlist){
            return response()->json(array('status' => true,'messsage' => 'wishlist removed.'), 200);
        }else{
            return response()->json(array('status' => false,'message' => 'nothing to remove.'), 200);
        }
    }
}
