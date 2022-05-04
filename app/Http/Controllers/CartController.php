<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;

session_start();

class CartController extends Controller
{
    public function save_cart(Request $request){
        $quantity = $request -> qty;
        $productID = $request -> productid_hidden;
        $product_info = DB::table('tbl_product') -> where('product_id',$productID) ->first();
        
    
        $data['id'] = $product_info -> product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info -> product_name;
        $data['price'] = $product_info -> product_price;
        $data['weight'] = '123';
        $data['options']['image'] = $product_info -> product_image;
        Cart::add($data);
        return Redirect::to('/show-cart');
    }
    public function show_cart(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','1') ->orderBy('category_id','desc') ->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc') -> get(); 
        return view('pages.cart.show_cart') -> with('category',$cate_product) -> with('brand',$brand_product) ;
    }
    public function delete_cart($rowId){
        Cart::update($rowId,0); // update voi rowId
        return Redirect::to('/show-cart');
    }
    public function update_cart(Request $request){
        $rowId = $request -> rowId_cart;
        $qty = $request -> quantity_cart;
        Cart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }
}
