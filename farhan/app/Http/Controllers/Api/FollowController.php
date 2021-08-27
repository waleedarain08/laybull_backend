<?php

namespace App\Http\Controllers\Api;

use App\Follow;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'follow_id'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        $check = Follow::where('follow_id', $request->follow_id)
                        ->where('user_id', Auth::user()->id)->first();

        if($check)
        {
            $status = 'True';
            $message = 'You Already Follow this User..';
            return response()->json(compact('status','message'),201);
        }

        $follow = new Follow();
        $follow->user_id = Auth::user()->id;
        $follow->follow_id = $request->follow_id;

        $follow->save();

        if($follow)
        {
            $status = 'True';
            $message = 'You Follow This User SuccessFully...';
            return response()->json(compact('status','message'),201);
        }
        else
        {
            $status = 'False';
            $message = 'Something Went Wrong';
            return response()->json(compact('status','message'),201);
        }
    }
    public function unfollow(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'follow_id'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        $follow = Follow::where('user_id', Auth::user()->id)
                            ->where('follow_id', $request->follow_id)->delete();


        if($follow)
        {
            $status = 'True';
            $message = 'You SuccessFully UnFollow This User...';
            return response()->json(compact('status','message'),201);
        }
        else
        {
            $status = 'False';
            $message = 'You Already UnFollow This User';
            return response()->json(compact('status','message'),201);
        }
    }
    public function myFollowers()
    {
        $followers = Follow::where('follow_id', Auth::user()->id)->count();

        if($followers > 0)
        {
            $status = 'True';
            $message = 'You Follow This User SuccessFully...';
            return response()->json(compact('status','message', 'followers'),201);
        }
        else
        {
            $status = 'False';
            $message = 'You have No Followers';
            return response()->json(compact('status','message', 'followers'),201);
        }
    }
}
