<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;


session_start();

class HomeController extends Controller
{
    public function send_mail(){
        // send mail
               $to_name = "Minh Khang Dev";
               $to_email = "khanglmps25822@fpt.edu.vn";//send to this email
              
            
               $data = array("name"=>"Mail từ KhangShop","body"=>'Mail gửi về vấn về hàng hóa'); //body of mail.blade.php
               
               Mail::send('pages.send_mail',$data,function($message) use ($to_name,$to_email){

                   $message->to($to_email)->subject('Test thử gửi mail google');//send this mail with subject
                   $message->from($to_email,$to_name);//send from this mail
               });
            //    return redirect('/')->with('message','');
         
   }
    public function index(Request $request){
        // seo
        $meta_desc = "Chuyên bán phụ kiên máy chụp hình";
        $meta_keywords = "may chup hinh, máy chụp hình, may quet, máy quét";
        $meta_title = "máy chụp ảnh chất lượng cao";
        $url_canonial = $request->url();
        // end seo
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        // ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        // ->orderby('tbl_product.product_id','desc')->get();
        $all_product = DB::table('tbl_product')->where('product_status','0')->orderby('product_id','desc')->limit(4)->get();
        return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonial)
        ;
        
    }
    public function search(Request $request){
        $keywords = $request->keywords_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        // ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        // ->orderby('tbl_product.product_id','desc')->get();
        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get();
        return view('pages.sanpham.search')->with('category',$cate_product)->with('brand',$brand_product)->with('search_product',$search_product);
    }
}
