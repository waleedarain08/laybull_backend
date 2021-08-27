<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Food,FoodProductReviews};
use Exception;

class FoodController extends Controller
{
    public $successStatus = 200;
    public function list(){
        $model = new Food();
        $records = $model->with('foodcategory')->get();
        if($records->count() > 0 ){
            $success['records'] = $records;
            return response()->json(['success' => $success], $this->successStatus);
        }else{
            $error['message'] = 'Data not found';
            return response()->json(['error' => $error], 404);
        }
    
       
    }
    public function foodproductstatus($id){
       try 
       {    
           $model = new Food();
            $records = $model->find($id);
            $records->status = !$records->status;
            if($records->save())
            {
                $success['status'] = $records->status;
                return response()->json(['success'=>$success],$this->successStatus);
            } 
            else
            {
                $error['message'] = 'Something Went Wrong';
                return response()->json(['error' => $error], 404);
            }
        }
        catch (Exception $e)
        {   
          $error['message'] = 'Invalid ID';
          return response()->json(['error' => $error], 404);
       }
    }
    // public function addfood(Request $request){
    //     $message = 'Food Added successfully';
    //    try 
    //    {
    //         $model =  new Food();
    //         $model->food_category_id =$request->food_category_id; 
    //         $model->name = $request->name;
    //         $model->quantity = $request->quantity;
    //         $model->price = $request->price;
    //         $model->status = $request->status;
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

        public function foodProductReviews($productId = null)
        {
            try
            {
              $model = new FoodProductReviews();
              if($productId)
              {
                $foodObj = new Food();
                $success['Food_Details'] = $foodObj->with('foodcategory')->find($productId);
                $records = $model->where('product_id',$productId)->get();   
              } 
              else
                $records = $model->get();
                if($records->count() > 0 )
                {
                    $success['Reviews'] = $records;
                    return response()->json(['success' => $success], $this->successStatus);
                }else
                {
                    $error['message'] = 'Data not found';
                    return response()->json(['error' => $error], 404);
                }


            }
            catch (Exception $th)
            {
                
            }


        }



}
