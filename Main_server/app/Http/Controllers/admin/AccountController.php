<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountPasswordUpdateRequest;
use App\Http\Requests\AccountRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function __construct()
    {

    }

    public function index(){
        $account_data = Admin::findOrFail(Auth::user()->id);;
        return view('admin.account', ['account_data' => $account_data]);
    }

    public function infoUpdate(AccountRequest $request, $id){
        $validated_data = $request->validated();

        $account_data = Admin::findOrFail($id);

        $account_data->first_name = $validated_data['first_name'];
        $account_data->last_name = $validated_data['last_name'];
        $account_data->contact_no = $validated_data['contact_no'];

        if($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');
            $path = 'uploads/admin/profile-pics/';
            $ext = $file->getClientOriginalExtension();
            $file_name = time().'.'.$ext;
            $file->move($path, $file_name);
            $account_data->profile_pic = $path.$file_name;
       }

       $account_data->update();

       return redirect()->route('account.index')->with('success', 'Admin info updated !');

    }

    public function passwordUpdate(AccountPasswordUpdateRequest $request, $id){

        $validatedData = $request->validated();

        $account_data = Admin::findOrFail($id);
        $account_data->password = Hash::make($validatedData['password']);

        $account_data->update();

        return redirect()->route('account.index')->with('success', 'Admin password updated !');
    }

}
