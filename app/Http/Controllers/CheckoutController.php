<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Cart; // su dung thu vien Cart (bumbummen99)
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
        $data['customer_password'] = md5($request->customer_password); 

        //insertGetId: sẽ lấy ra id của dữ liệu vừa insert
        $customer_id = DB::table('tbl_customers')->insertGetId($data);
        //lấy ra customer_id từ dữ liệu mới thêm ở trên gán vào biến customer_id
        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);

        return Redirect::to('/checkout');

    }

    public function checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        return view('pages.checkout.show_checkout')
            ->with('category',$cate_product)
            ->with('brand',$brand_product);
    }

    public function save_checkout_customer(Request $request){
        $data = array();

        //trường customer_name = name của input tương ứng trong form
        $data['shipping_name'] = $request->shipping_name; 
        $data['shipping_phone'] = $request->shipping_phone; 
        $data['shipping_email'] = $request->shipping_email; 
        $data['shipping_notes'] = $request->shipping_notes; 
        $data['shipping_address'] = $request->shipping_address; 

        //insertGetId: sẽ lấy ra id của dữ liệu vừa insert
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        //lấy ra customer_id từ dữ liệu mới thêm ở trên gán vào biến customer_id
        Session::put('shipping_id', $shipping_id);

        return Redirect::to('/payment');
    }

    public function payment(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        return view('pages.checkout.payment')
            ->with('category',$cate_product)
            ->with('brand',$brand_product);
    }

    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }

    public function order_place(Request $request){
        //insert payment method
        $data = array();
        $data['payment_method'] = $request->payment_option; 
        $data['payment_status'] = 'Đang chờ xử lý'; 
        //insertGetId: sẽ lấy ra id của dữ liệu vừa insert
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id'); 
        $order_data['shipping_id'] = Session::get('shipping_id'); 
        $order_data['payment_id'] = $payment_id; 
        $order_data['order_total'] = Cart::total(); 
        $order_data['order_status'] = 'Đang chờ xử lý';  

        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //insert order details
        //su dung content trong thu vien Cart
        $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data = array();
            $order_d_data['order_id'] = $order_id; 
            $order_d_data['product_id'] = $v_content->id; 
            $order_d_data['product_name'] = $v_content->name; 
            $order_d_data['product_price'] = $v_content->price; 
            $order_d_data['product_sales_quantity'] =  $v_content->qty;  
    
            $order_details_id = DB::table('tbl_order_details')->insert($order_d_data);
        }

        if($data['payment_method'] == 1){
            echo 'Thanh toán bằng thẻ ATM';
        } elseif($data['payment_method'] == 2){
            echo 'Thanh toán bằng tiền mặt';
        } else{
            echo 'Thẻ ghi nợ';
        }
        // return Redirect::to('/payment');
    }

    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customers')->where('customer_email', $email)->where('customer_password', $password)->first();
        if($result){
            Session::put('customer_id', $result->customer_id);
            return Redirect::to('/checkout');
        } else{
            return Redirect::to('/login-checkout');
        }

    }

}
