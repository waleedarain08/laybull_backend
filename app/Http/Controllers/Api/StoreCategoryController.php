<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{StoreCategory,User, StoreVendorReviews};
use Illuminate\Support\Facades\DB;


class StoreCategoryController extends Controller
{
    public $successStatus = 200;
    public function list($vendorId = null)
    {
        try
        {
            $model =  new StoreCategory();
            if($vendorId)
            {
                $userObj = new User();
                $success['shop'] =$userObj->with('detail')->find($vendorId);
                $records = $model->where('vendor_id',$vendorId)->with('products')->get();
            }
            else
            $records = $model->with('products')->get();
            if($records->count() > 0 )
            {
            $success['records'] = $records;
            return response()->json(['success' => $success], $this->successStatus);
            }
            else
            {
                $error['message'] = 'Data not found';
                return response()->json(['error' => $error], 404);
            }
        } 
        catch (Exception $e)
        {
             $error['message'] = $e->getMessage();
             return response()->json(['error'=>$error],404);
        }
       
        
    }
    public function vendors()
    {
        $model = new User();
        $records = $model->where('role','vendor')
                        ->whereNotNull('modules')
                        ->where('status', 1)
                        ->whereHas('storeProducts')
                        ->where('modules','like','%store%')
                        ->withCount('storeReviews as totalReviews')
                        ->with(['detail', 'locations', 'storeProducts'])
                        ->latest()
                        ->get();
        $recordsArray = $records->toArray();
        foreach($recordsArray as $key=>$value)
            {
                $id = $value['id'];
                $avgQuery = DB::select("SELECT AVG(rating) AS averageRating FROM store_vendor_reviews WHERE vendor_id=$id");
                $avgRating = head($avgQuery)->averageRating;
                $recordsArray[$key]['avgRating'] = $avgRating ?? 0;
            }                

        if($records->count() > 0)
        {
            $success['records'] = collect($recordsArray);
            return response()->json(['success' => $success], $this->successStatus);
        }                
        else
        {
            $error['error'] = 'Data Not Found';
            return response()->json(['error'=>$error],404);
        }

    }

    public function vendorreviews($vendorId = null)
    {
        try
        {
            $model =  new StoreVendorReviews();
            if($vendorId)
            {
                $userObj = new User();
                $query = DB::select("SELECT AVG(rating) AS averageRating FROM store_vendor_reviews WHERE vendor_id=$vendorId");
                $avgRating = head($query)->averageRating;
                $success['vendorDetails'] = $userObj->withCount('storeReviews as totalReviews')->with(['detail'])->find($vendorId);
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
}
