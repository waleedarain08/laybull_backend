<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{User,UserLocation};
use Illuminate\Support\Facades\Validator;

class UserLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $successStatus = 200;
    public function index()
    {
        //
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
   public function store(Request $request,$user_Id)
    {
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'address'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            'user_id' => 'required'
        ]);
        if($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()],401);
        }
        $message = 'UserLocation successfully created';
        try
        {
            $userObj = User::find($user_Id);
            if($userObj)
            {
                extract($request->all());
                $model = new UserLocation();
                $model->user_id = $user_Id;
                $model->title = $title;
                $model->address = $address;
                $model->latitude = $latitude;
                $model->longitude = $longitude;
                $model->save();
                $records =  $model->where('user_id', $user_Id)->latest()->get();
                $success['records'] = $records;
                
                return response()->json(['success'=> $success],$this->successStatus);
            }
            else
            {
                return response()->json(['error'=>'Invalid Id'],401);
            }            
        }
        catch (Exception $e)
        {
            return response()->json(['error'=>$e],401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $model = new UserLocation();
            $records =  $model->where('user_id', $id)->latest()->get();
            $success['records'] = $records; 
            if($records)
            {
                return response()->json(['success'=> $success]);
            } 
            else
            {
                $error = 'Something went wrong';
                return response()->json(['success'=> $error], 404);
            }
        }
        catch (Exception $e)
        {
            return response()->json(['error'=>$e],401);
        }
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
        $validator = Validator::make($request->all(),[
            
            'title'=>'nullable',
            'address'=>'nullable',
            'latitude'=>'nullable',
            'longitude'=>'nullable'
        ]);
        if($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()],401);
        }
        $message = 'UserLocation successfully Updated';
        try
        {
           
            extract($request->all());
            $model = new UserLocation();
            $record = $model->find($id);
            if($record)
            {
                $record->title = $title ?? $record->title;
                $record->address = $address ?? $record->address;
                $record->latitude = $latitude ?? $record->latitude;
                $record->longitude = $longitude ?? $record->longitude;
                $record->save();
                
                $recorduser = new User();
                $recorduser = $recorduser->where('id',$record->user_id)->with('detail')->get(); 
                return response()->json(['success'=>$recorduser,'location'=>$record],$this->successStatus);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try 
        {
            $model = new UserLocation();
            $record = $model->find($id);
            if($record)
            {
                $userId = $record->user_id;
                $record->delete();
                $allRecords = $model->where('user_id', $userId)->latest()->get();    
                $success['records'] = $allRecords; 
                return response()->json(['success'=>$success], $this->successStatus);
            }
            else
            {
                return response()->json(['error'=>'Invalid ID'], 404);
            }
        } 
        catch (Exception $e)
        {
            return response()->json(['error'=>$e],401);
        }
    }
}
