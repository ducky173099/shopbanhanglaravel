<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Cart; // su dung thu vien Cart (bumbummen99)
session_start();

class CartController extends Controller
{
    public function save_cart(Request $request){
        // lay ra 2 trường từ form với name là productid_hidden và qty
        $poductId = $request->productid_hidden;
        $quantity = $request->qty;

        $product_info = DB::table('tbl_product')->where('product_id',$poductId)->first();

        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = '123';
        $data['options']['image'] = $product_info->product_image;

        Cart::add($data);
        // Cart::destroy();
        return Redirect::to('/show-cart');
    }

    public function show_cart(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        return view('pages.cart.show_cart')
        ->with('category', $cate_product)
        ->with('brand', $brand_product);
    }

    public function delete_to_cart($rowId){
        Cart::update($rowId, 0); //xoa san pham bang cach set rowId = 0 (số lượng bằng 0)
        return Redirect::to('/show-cart');
    }

    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId_cart; //rowId_cart la name cua input
        $qty = $request->cart_quantity; //cart_quantity la name cua input

        Cart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }
}
