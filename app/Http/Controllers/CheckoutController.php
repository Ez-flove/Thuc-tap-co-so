<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;

session_start();

class CheckoutController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
             return Redirect::to('dashboard');
        } 
        else{
            return Redirect::to('admin') ->send();
        }
    }
    public function login_checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','1') ->orderBy('category_id','desc') ->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc') -> get(); 
        return view('pages.checkout.login_checkout')->with('category',$cate_product) -> with('brand',$brand_product);
    }
    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request -> customer_name;
        $data['customer_phone'] = $request -> customer_phone;
        $data['customer_email'] = $request -> customer_email;
        $data['customer_password'] = md5($request -> customer_pass);
        $results = DB::select('select customer_email from tbl_customers');
        $newResults = (array) array_values($results);
        // foreach ($results as $user) {
        //       $user->customer_email;
        // }
        // if(strpos($results,$data['customer_email'])!==false){
        //     return Redirect::to('/login-checkout');
        // }
        // else{
        //     $customer_id = DB::table('tbl_customers') -> insertGetId($data);
        //      Session::put('customer_id',$customer_id);
        //      Session::put('customer_name',$request->customer_name);
        //  return Redirect::to('/checkout');
        // }
        echo '<pre>';
        print_r($newResults);
        echo '<pre>';
        echo '<pre>';
        print_r($data);
        echo '<pre>';
    }
    public function checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','1') ->orderBy('category_id','desc') ->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc') -> get(); 
        return view('pages.checkout.show_checkout')->with('category',$cate_product) -> with('brand',$brand_product);
    }
    public function order_place(Request $request){
        //insert payment method lay ra cac hinh thuc thanh toan
        $data = array();
        $data['payment_method'] = $request -> payment_option;
        $data['payment_status'] = 'Đang xử lí';
        $data['payment_method'] = $request -> payment_option;
        $payment_id = DB::table('tbl_payment') ->insertGetId($data);

        // insert order lay ra thong tin order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Đang xử lí';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        // insert order details lay ra thong tin thanh toan cuoi cung
        $content = Cart::content();
        foreach ($content as $key => $v_content) {
            $order_d_data = array();
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insertGetId($order_d_data);
        }
        if($data['payment_method']==1){
            echo 'Thanh toan the ATM';
        }
        elseif($data['payment_method']==2){
            Cart::destroy();
            $cate_product = DB::table('tbl_category_product')->where('category_status','1') ->orderBy('category_id','desc') ->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc') -> get(); 
            return view('pages.checkout.handcash')->with('category',$cate_product) -> with('brand',$brand_product);
        }
        else{
            echo 'Momo';
        }
        //return Redirect::to('/payment');
    }
    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request -> shipping_name;
        $data['shipping_phone'] = $request -> shipping_phone;
        $data['shipping_email'] = $request -> shipping_email;
        $data['shipping_note'] = $request -> shipping_note;
        $data['shipping_addres'] = $request -> shipping_add;
        $shipping_id = DB::table('tbl_shipping') -> insertGetId($data);

        Session::put('shipping_id',$shipping_id);
        return Redirect::to('/payment');
    }
    public function payment(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','1') ->orderBy('category_id','desc') ->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc') -> get(); 
        return view('pages.checkout.payment')->with('category',$cate_product) -> with('brand',$brand_product);
    }
    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request){
        // bities@gmail.com pass:1122    b19@gmail.com pass:1234567
        $email = $request -> email_acc;
        $pass = md5($request -> pass_acc);
        $result = DB::table('tbl_customers') -> where('customer_email',$email) -> where('customer_password',$pass) -> first();
        if($result){
            Session::put('customer_id',$result->customer_id);
            Session::put('customer_name',$result->customer_name);
            return Redirect::to('/checkout');
        }else{
            return Redirect::to('/login-checkout');
        }
    }
    
    public function manage_order(){
        $this -> AuthLogin();

        $all_order =  DB::table('tbl_order') 
        -> join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        -> select('tbl_order.*','tbl_customers.customer_name')
        ->orderby('tbl_order.order_id','desc') -> get();
        $manager_order = view('admin.manage_order') -> with('all_order',$all_order); 
        return view('admin-layout')->with('admin.manage_order',$manager_order);
    }
    public function view_order($orderId){
        $this -> AuthLogin();

        $order_byid =  DB::table('tbl_order') 
        -> join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        -> join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        -> join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        -> select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_details.*') ->where('tbl_order.order_id', $orderId)-> first();

        $manager_order_byid = view('admin.view_order') -> with('order_byid',$order_byid); 
        return view('admin-layout')->with('admin.view_order',$manager_order_byid);
    }
   
}
 