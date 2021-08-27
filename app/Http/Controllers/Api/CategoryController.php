<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
use App\Brand;
use Illuminate\Http\Request;
use Exception;
use App\FoodCategory;
use App\User;
use App\FoodVendorReviews;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public $successStatus = 200;
    public function index()
    {
        // 10 indicates the number of records
        $cats = Category::where('parent','=','0')
            ->get();
        $categories =  array();
        $i = 0;
//        foreach($cats as $cat){
//
//            if($cat->parent == 0){
//                $categories[$i]['Parent'] = $cat;
//
//                $childs = Category::where('parent','=',$cat->id)
//                    ->get();
//
//                $s= 0;
//                foreach($childs as $child){
//
//                    $categories[$i]['child'][$s] = $child;
//                    $subchild = Category::where('parent','=',$child->id)
//                        ->get();
//
//                    $categories[$i]['child'][$s]['subchild'] = $subchild;
//                    $s++;
//                }
//
//            }
//
//            $i++;
//
//        }
        return response()->json([$cats]);
    }

    public function show($id)
    {
        $cats = Category::where('id','=',$id)->get();


        $products =  array();
        $i = 0;
        foreach($cats as $cat){

            $prods =  $cat->product;
            foreach($prods as $prod){

                $prodBrand = Brand::where('id','=',$prod->brand)->first();
                $prodSize = $prod->sizess;
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

            $i++;

        }
        return $cats;
    }

    public function list($vendorId = null)
    {
        try
        {
            $model =  new FoodCategory();
            if($vendorId){
                $userObj = new User();
                $success['shop'] = $userObj->with('detail')->find($vendorId);
                $records = $model->where('vendor_id',$vendorId)->with('products')->get();
            }
            else
                $records = $model->with('products')->get();

            if($records->count() > 0 )
            {
                $success['records'] = $records;
                return response()->json(['success' => $success], $this->successStatus);
            }else
            {
                $error['message'] = 'Data not found';
                return response()->json(['error' => $error], 404);
            }
        }
        catch(Exception $e){
            $error['message'] = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }
    }

    // public function addfoodcategory(Request $request){
    //     $message = 'Food Added successfully';
    //    try
    //    {
    //         $model =  new FoodCategory();
    //         $model->name = $request->name;
    //         if($model->save())
    //         {
    //             return response()->json(['success'=>$message],$this->successStatus);
    //         }
    //    }
    //    catch (Exception $e)
    //    {
    //         return response()->json(['error'=>$e],401);
    //    }


    // }



    public function vendors()
    {
        $model =new User();
        $records = $model->where('role','vendor')
            ->whereNotNull('modules')
            ->where('modules','like', '%food%')
            ->where('status', 1)
            ->whereHas('food')
            ->withCount('foodReviews as totalReviews')
            ->with(['detail', 'locations','food'])
            ->latest()
            ->get();

        $recordsArray = $records->toArray();
        foreach($recordsArray as $key=>$value)
            {
                $id = $value['id'];
                $avgQuery = DB::select("SELECT AVG(rating) AS averageRating FROM food_vendor_reviews WHERE vendor_id=$id");
                $avgRating = head($avgQuery)->averageRating;
                $recordsArray[$key]['avgRating'] = $avgRating ?? 0;
            }

        if($records->count() > 0 ){

            $success['records'] = collect($recordsArray);
            return response()->json(['success' => $success], $this->successStatus);


        }else{
            $error['message'] = 'Data not found';
            return response()->json(['error' => $error], 404);
        }
    }
    public function vendorreviews($vendorId = null)
    {
        try
        {
            $model =  new FoodVendorReviews();
            if($vendorId)
            {
                $userObj = new User();
                $query = DB::select("SELECT AVG(rating) AS averageRating FROM food_vendor_reviews WHERE vendor_id=$vendorId");
                $avgRating = head($query)->averageRating;
                $success['vendorDetails'] = $userObj->withCount('foodReviews as totalReviews')->with(['detail'])->find($vendorId);
                $success['vendorDetails']['averageRating'] = $avgRating;
                $records = $model->where('vendor_id',$vendorId)->with('user.detail')->get();
            }
            else
                $records = $model->get();

            if($records->count() > 0 )
            {
                $success['records'] = $records;
                return response()->json(['success'=>$success], $this->successStatus);
            }else
            {
                $error['message'] = 'Data not found';
                return response()->json(['error' => $error], 404);
            }
        }
        catch(Exception $e){
            $error['message'] = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }


    }

    public function brands()
    {
        $brands = Brand::all();

        return response()->json($brands);
    }

    public function allCategories()
    {
        $categories = Category::all();

        if($categories)
        {
            $status = 'True';
            $message = 'All  Categories...';
            return response()->json(compact('status','message','categories'),201);
        }
        else
        {
            $status = 'False';
            $message = 'Something Went Wrong';
            return response()->json(compact('status','message'),201);
        }
    }

    public function getSingleCategory(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_id'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        $category = Category::findOrFail($request->category_id);

        if($category)
        {
            $status = 'True';
            $message = 'Product Find SuccessFully...';
            return response()->json(compact('status','message','category'),201);
        }
        else
        {
            $status = 'False';
            $message = 'Something Went Wrong';
            return response()->json(compact('status','message'),201);
        }
    }
}
