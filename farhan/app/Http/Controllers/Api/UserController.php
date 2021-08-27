<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{User, UserDetail, FoodBooking, GroceryBooking, StoreBooking};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public $successStatus = 200;
    public function list()
    {
        $model =  new User();
        $records = $model->with('detail')->get();
        if($records->count() > 0 ){
            $success['records'] = $records;
            return response()->json(['success' => $success], $this->successStatus);
        }else{
            $error['message'] = 'Data not found';
            return response()->json(['error' => $error], 404);
        }

    }
    public function fetchAllVendors()
    {
        $model =  new User();
        $records = $model->with('detail')->where('role', 'vendor')->get();
        if($records->count() > 0 ){
            $success['records'] = $records;
            return response()->json(['success' => $success], $this->successStatus);
        }else{
            $error['message'] = 'Data not found';
            return response()->json(['error' => $error], 404);
        }
    }
     public function useredit(Request $request,$id)
    {
        // print_r($request->all());
        // exit;

        $validator = Validator::make($request->all(),[
            'name'=>'nullable',
            'password'=>'nullable',
            'image'=>'nullable',
            'phone'=>'nullable'
        ]);
        if($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()],401);
        }
        try
        {
            extract($request->all());
            $model = new User();
            $record = $model->find($id);
            if($record)
            {
                $record->name = $name ?? $record->name;
            $record->password = isset($password) && $password ? Hash::make($password) : $record->password;
            $record->save();

            $modeldetails = new UserDetail();
            $modeldetails = $modeldetails->where('user_id', $id)->first();

            $modeldetails->user_name = $record->name;
            $modeldetails->phone = $phone ?? $modeldetails->phone;
            if($request->hasfile('image')){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/usersimage/',$filename);
                $modeldetails->image = $filename;
            }
            else
            {
                $modeldetails->image = $modeldetails->getRawOriginal('image');
            }
            $modeldetails->save();
            $user = $record;
            $detail = $modeldetails;
            $success['user'] = $record;
            $success['detail'] = $modeldetails;
            return response()->json(['success'=> $success],$this->successStatus);
            }
            else
            {
                return response()->json(['error'=>'Invalid ID']);
            }

        }
        catch (Exception $e)
        {
            return response()->json(['error'=>$e],401);
        }

    }

    public function stats($id){

        try{
             $foodModel = new FoodBooking();
            $food = $foodModel->where('user_id', $id)->sum('total_price');
            $groceryModel = new GroceryBooking();
            $grocery = $groceryModel->where('user_id', $id)->sum('total_price');
            $storeModel = new StoreBooking();
            $store = $storeModel->where('user_id', $id)->sum('total_price');
            $result['foodTotal'] = number_format($food, 2);
            $result['groceryTotal'] = number_format($grocery, 2);
            $result['storeTotal'] = number_format($store, 2);
            $success['records'] = $result;

        return response()->json(['success' => $success], $this->successStatus);
        }catch(Execption $e){
            $error['message'] = 'something went wrong';
            return response()->json(['error' => $error], 404);
        }
    }

    public function getUser()
    {
        $user = User::with('detail')->find(Auth::user()->id);
        if($user)
        {
            $status = 'True';
            $message = 'User Detail.';
            return response()->json(compact('status','message','user'),201);
        }
        else
        {
            $status = 'False';
            $message = 'Something Went Wrong';
            return response()->json(compact('status','message'),201);
        }
    }
}
