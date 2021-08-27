<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\{UserStore,UserUpdateStore};
use Illuminate\Http\Request;
use App\{User,UserDetail,UserLocation,BankAccount};
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $model = new User();
        $records = $model->latest()->paginate(config('app.pagination_length'));
        return view('users.index', compact('records'));
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(UserStore $request)
    {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);

            $module = '';
            foreach($request->modules as $items)
            {
                $module.=$items.",";
            }
            $allitems = rtrim($module,",");
            $user->modules = $allitems;
            $user->status = $request->status;
            $user->currency = $request->currency;
            $user->reservation = isset($request->reservation) ? 1 : 0;
            $user->save();

            $userdetail = new UserDetail();
            $userdetail->user_id = $user->id;
            $userdetail->user_name = $request->name;
            $userdetail->phone = $request->phone;
            $userdetail->email = $request->email;
            $userdetail->service_tax = $request->tax;
            $userdetail->delivery_fees = $request->fees;
            $userdetail->takeaway_tax = $request->takeaway;

            if($request->hasfile('photo')){
                $file =  $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/usersimage/',$filename);
                $userdetail->image = $filename;
            }
            $userdetail->save();

            $location = new UserLocation();
            $location->title = "shop";
            $location->latitude =$request->latitude;
            $location->longitude =$request->longitude;
            $location->user_id =$user->id;
            $location->address = $request->address;
            $location->save();

            $accountModel = new BankAccount();
            $accountModel->vendor_id = $user->id;
            $accountModel->account_number = $request->account_number;
            $accountModel->save();

            return redirect()->route('user.index')->with('insert','Vendor Added Successfully');

    }
    public function edit($id)
    {
        $model =  new User();
        $record =  $model->with('detail','location','bankaccount')->find($id);
        //dd($record);
        return view('users.edit', compact('record'));
    }
    public function update(UserUpdateStore $request,$id)
    {
        //dd($request->all());
        try{
            $data = $request->validated();
            extract($data);
            $model = User::find($id);
            if($model)
            {
                $model->name = $name;
            $model->password = (isset($password) && $password) ? Hash::make($password) : $model->password;
            $mod = '';
            foreach($modules as $item){
                $mod.=$item.",";
            }
            $allmodules = rtrim($mod,',');
            $model->modules=$allmodules;
            $model->currency = $currency ?? $model->currency;
            $model->save();
            $detail = new UserDetail();
            $recorddetail = $detail->where('user_id',$id)->first();
            $recorddetail->phone = $phone ?? $recorddetail->phone;
            $recorddetail->address = $address ?? $recorddetail->address;
            $recorddetail->service_tax = isset($tax) ? $tax : $recorddetail->service_tax;
            $recorddetail->delivery_fees = isset($fees) ? $fees :  $recorddetail->delivery_fees;
            $recorddetail->takeaway_tax = isset($takeaway) ? $takeaway : $userdetail->takeaway_tax;
            if($request->hasfile('photo')){
                if(file_exists(public_path('uploads/userimage/'.$recorddetail->image))){
                    @unlink('uploads/userimage/'.$recorddetail->image);
                }
                $file =  $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/usersimage/',$filename);
                $recorddetail->image = $filename ?? $recorddetail->image;
            }
            $recorddetail->save();
            $location = new UserLocation();
            $recordlocation = $location->where('user_id',$id)->first();
            $recordlocation->latitude =$latitude ?? $recordlocation->latitude;
            $recordlocation->longitude =$longitude ?? $recordlocation->longitude;
            $recordlocation->address =$address ?? $recordlocation->address;
            $recordlocation->save();

            $accountModel = new BankAccount();
            if($accountrecord = $accountModel->where('vendor_id',$id)->first()){
                $accountrecord->account_number = $account_number ?? $accountrecord->account_number;
                $accountrecord->save();
            }else{
                $accountModel->vendor_id = $model->id;
                $accountModel->account_number = $account_number;
                $accountModel->save();
            }

            return redirect()->route('user.index')->with('update','Record Updated Successfully');
            }
            else
            {
                return redirect()->back();
            }
        }
        catch (Exception $e)
        {
            dd($e);
            exit;
        return redirect()->back()->with('error','something went wrong');
        }

    }
//    public function userstatus($id)
//    {
//        $model =  new User();
//        $record =  $model->find($id);
//        $record->status = !$record->status;
//        if($record->save())
//        {
//            return redirect()->back()->with('status','Status Updated Successfully');
//        }
//        else
//        {
//            return redirect()->route('updateuserstatus');
//        }
//
//    }

    public function block_user($id)
    {

        $record =  User::find($id);
        if($record->status == 1){
            $record->status = 0;
            $message = 'User has been blocked';
        }else{
            $record->status = 1;
            $message = 'User has been unblocked';
        }
        if($record->save())
        {
            return redirect()->back()->with('status',$message);
        }
        else
        {
            return redirect()->back()->with('status','something went wrong!');
        }

    }

}
