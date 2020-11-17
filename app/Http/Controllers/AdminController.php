<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();


class AdminController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        } else{
            return Redirect::to('admin')->send();
        }
    }

    public function index(){
        return view('admin_login');
    }

    public function show_dashboard(){
        $this->AuthLogin();
        return view('admin.dashboard');
    }

    public function dashboard(Request $request){
    	$admin_email = $request->admin_email;
    	$admin_password = md5($request->admin_password);

    	//result lay ket qua tu bang tbl_admin o DB va kiem tra email va pass
    	$result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        // print_r($result);
        if ($result) {
        	// neu dang nhap dung thi gán gt admin_name = admin_name, admin_id = admin_id tu results
        	Session::put('admin_name', $result->admin_name);
        	Session::put('admin_id', $result->admin_id);
        	return Redirect::to('/dashboard');

         	// return view('admin.dashboard');
        } else{
        	 	Session::put('message', 'Mật khẩu hoặc tài khoản sai!');
    	  	return Redirect::to('/admin');
        }
    }

    public function logout(){
        $this->AuthLogin();
     	Session::put('admin_name', null);
    	Session::put('admin_id', null);
    	return Redirect::to('/admin');
    }
}
