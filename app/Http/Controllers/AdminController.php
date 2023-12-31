<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Cookie;

class AdminController extends Controller
{
    // Login
    function login(){
        return view('adminlogin');
    }

    // Check Login
    function check_login(Request $request){
        $request->validate([
            'username'=>'required',
            'password'=>'required',
        ]);
        $admin=Admin::where(['username'=>$request->username,'password'=>$request->password])->count();
        if($admin>0){
            $adminData=Admin::where(['username'=>$request->username,'password'=>$request->password])->get();
            session(['adminData'=>$adminData]);

            if($request->has('rememberme')){
                Cookie::queue('adminuser',$request->username,1440);
                Cookie::queue('adminpwd',$request->password,1440);
            }

            return redirect('admin');
        }else{
            return redirect('admin/adminlogin')->with('msg','Invalid username/Password!!');
        }
    }

    // Logout
    function logout(){
        session()->forget(['adminData']);
        return redirect('admin/adminlogin');
    }

    
    
}
