<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class BrandProduct extends Controller
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
    public function add_brand_product(){
        $this -> AuthLogin();

        return view('admin.add_brand_product');
    }
    public function all_brand_product(){
        $this -> AuthLogin();

        $all_brand_product =  DB::table('tbl_brand') -> get();
        $manager_brand_product = view('admin.all_brand_product') -> with('all_brand_poduct',$all_brand_product); 
        return view('admin-layout') -> with('admin.all_brand_product',$manager_brand_product);
    }
    public function save_brand_product(Request $request){
        $this -> AuthLogin();

       $data = array();
       $data['brand_name'] = $request -> brand_product_name; // [in [] is name of data in mysql] 
       $data['brand_desc'] = $request -> brand_product_desc; // [in [] is name of data in mysql] 
       $data['brand_status'] = $request -> brand_product_status; // [in [] is name of data in mysql] 
       DB::table('tbl_brand') -> insert($data);
       Session::put('message', 'Thêm thương hiệu thành công');
       return Redirect::to('/add-brand-product');      
    }
    public function unactive_brand_product($brand_product_id){
        $this -> AuthLogin();

        DB::table('tbl_brand') -> where('brand_id',$brand_product_id) -> update(['brand_status' => 1]);
        Session::put('message', 'Hiển thị thương hiệu thành công');
       return Redirect::to('/all-brand-product');
    }
    public function active_brand_product($brand_product_id){
        $this -> AuthLogin();

        DB::table('tbl_brand') -> where('brand_id',$brand_product_id) -> update(['brand_status' => 0]);
        Session::put('message', 'Ẩn thương hiệu thành công');
        return Redirect::to('/all-brand-product');
    }
    public function edit_brand_product($brand_product_id){
        $this -> AuthLogin();

        $edit_brand_product =  DB::table('tbl_brand') -> where('brand_id',$brand_product_id) -> get();
        $manager_brand_product = view('admin.edit_brand_product') -> with('edit_brand_poduct',$edit_brand_product); 
        return view('admin-layout') -> with('admin.edit_brand_product',$manager_brand_product);
    }
    public function update_brand_product(Request $request, $brand_product_id){
        $this -> AuthLogin();

        $data = array();
        $data['brand_name'] = $request -> brand_product_name; 
        $data['brand_desc'] = $request -> brand_product_desc;
        DB::table('tbl_brand') -> where('brand_id',$brand_product_id) -> update($data);
        Session::put('message', 'Cập nhật thương hiệu thành công');
        return Redirect::to('/all-brand-product');
    }
    public function delete_brand_product($brand_product_id){
        $this -> AuthLogin();

        DB::table('tbl_brand') -> where('brand_id',$brand_product_id) -> delete();
        Session::put('message', 'Xóa thương hiệu thành công');
        return Redirect::to('/all-brand-product');
    }
    //End Admin pages

    public function show_brand_home($brand_id){
        $cate_product = DB::table('tbl_category_product')->where('category_status','1') ->orderBy('category_id','desc') ->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc') -> get(); 
        $brand_by_id = DB::table('tbl_product') -> join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')
        -> where('tbl_product.brand_id',$brand_id) ->get();
        $brand_by_name = DB::table('tbl_brand') -> where('tbl_brand.brand_id',$brand_id) ->limit(1) ->get();
        
        return view('pages.brand.show_brand') -> with('category',$cate_product) -> with('brand',$brand_product) -> with('brand_by_id',$brand_by_id)  ->with('brand_by_name',$brand_by_name);
    }
}
