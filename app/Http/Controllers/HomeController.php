<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','1') ->orderBy('category_id','desc') ->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc') -> get(); 
        $all_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','desc') -> limit(6) -> get(); 
        return view('pages.home') -> with('category',$cate_product) -> with('brand',$brand_product) -> with('all_product',$all_product);
    }
    public function search(Request $request){
        $keywords = $request -> keywords_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status','1') ->orderBy('category_id','desc') ->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc') -> get(); 
        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%') -> limit(6) -> get(); 

        return view('pages.products.search') -> with('category',$cate_product) -> with('brand',$brand_product) ->with('search_product',$search_product);
    }

}
