<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\StoreProduct;
use Exception;

class StoreProductController extends Controller
{
    public $successStatus = 200;
    public function list()
    {
        $model = new StoreProduct();
        $records = $model->with('category')->get();
        if($records->count() > 0 ){
            $success['records'] = $records;
            return response()->json(['success' => $success], $this->successStatus);
        }else{
            $error['message'] = 'Data not found';
            return response()->json(['error' => $error], 404);
        }
    }
    public function storeproductstatus($id)
    {
       try 
       {
            $model = new StoreProduct();
            $records=$model->find($id);
            $records->status=!$records->status;
            if($records->save())
            {
                $success['status'] = $records->status;
                return response()->json(['success'=>$success],$this->successStatus);
            } 
            else
            {
                $error['message'] = 'Status Not Change';
                return response()->json(['error' => $error], 404);
            }
        } 
        catch (Exception $e)
        {
            $error['message'] = 'Invalid ID';
            return response()->json(['error' => $error], 404);
        }
    }
}
