<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\{User,UserDetail,Rider};
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\OAuth\OAuthErrorException;

use Octw\Aramex\Aramex;
class AuthenticateController extends Controller
{
    public function signup(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
                'fname'=>'required|string',
                'lname'=>'required|string',
                'email'=>'required|string|email|unique:users',
                'password'=>'required|min:8',
                'phone'=>'required',
                'country'=>'required',
                'city'=>'required',
                'address'=>'required',
                'currency'=>'required',
                'profile_image'=>'required'
            ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        $data = Aramex::validateAddress([
    'line1'=>$request->address, // optional (Passing it is recommended)
    // 'line2'=>'Test', // optional
    // 'line3'=>'Test', // optional
    'country_code'=>$request->country_code,
    // 'postal_code'=>'', // optional
    'city'=>$request->city,
  ]);
  if(!isset($data->error))
{
        try {
            $user = new User();
            $user->name = $request->fname.' '.$request->lname;
            $user->email = $request->email;
            $user->role = 'user';
            $user->currency = $request->currency;
            $user->is_seller=$request->is_seller;
            
            $user->password = Hash::make($request->password);
            $user->save();

            $userdetail = new UserDetail();
            $userdetail->user_id = $user->id;
            $userdetail->fname = $request->fname;
            $userdetail->lname = $request->lname;
            $userdetail->phone = $request->phone;
            $userdetail->country = $request->country;
            $userdetail->city = $request->city;
            $userdetail->address = $request->address;
            $userdetail->account_holder_name = $request->account_holder_name;
            $userdetail->account_number = $request->account_number;
            $userdetail->account_phone_number = $request->account_phone_number;
            $userdetail->account_bank_name = $request->account_bank_name;
            
            
             if($request->hasFile('profile_image'))
        {
            $file =  $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/user_profile/',$filename);
            $userdetail->image = $filename ?? $product->feature_image;
        }

            $userdetail->save();
            }
        catch (Exception $e)
        {
            return response()->json(['error'=>$e],401);
        }
}
 else
  {
            return response()->json(['status'=>false,'error'=>1,'data'=>$data]);
         
  }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $token = Auth()->user()->createToken('Token')->accessToken;
        }
        else
        {
            return response()->json(['status' => 'False', 'message' => 'Invalid Credentials'], 400);
        }

        $user = $user->refresh();
        $status = 'True';
        $message = 'User Registered Successfully.';
        return response()->json(compact('status','message','user','token'),201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

    	$status = 'True';
        $message = 'User Login Successfully.';

        $credentials = $request->only('email', 'password');
		$user = User::with('detail')->where('email','=',$credentials['email'])->get()->first();
            //   $user_details=  UserDetail::where('user_id',$user->id)->first();

        try{

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            {
                $token = Auth()->user()->createToken('Token')->accessToken;
            }
            else
            {
                return response()->json(['status' => 'False', 'message' => 'Invalid Credentials'], 400);
            }

        } catch (OAuthErrorException $e){
            return response()->json(['status' => 'False', 'message' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('status','message','user','token'),201);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
