<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
{
    public function login_checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        return view('pages.checkout.login_checkout')
            ->with('category',$cate_product)
            ->with('brand',$brand_product);
    }

    public function add_customer(Request $request){
        $data = array();

        //trường customer_name = name của input tương ứng trong form
        $data['customer_name'] = $request->customer_name; 
        $data['customer_phone'] = $request->customer_phone; 
        $data['customer_email'] = $request->customer_email; 
        $data['customer_password'] = $request->customer_password; 

        //insertGetId: sẽ lấy ra id của dữ liệu vừa insert
        $customer_id = DB::table('tbl_customers')->insertGetId($data);
        //lấy ra customer_id từ dữ liệu mới thêm ở trên gán vào biến customer_id
        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);

        return Redirect::to('/checkout');

    }

    public function checkout(){
        echo 'checkoutt';
    }

}