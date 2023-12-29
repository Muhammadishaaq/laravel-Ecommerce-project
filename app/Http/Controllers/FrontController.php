<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $featuredproducts=Product::where('is_featured','1')->orderBy('id','DESC')->take(8)->where('status','1')->get();
        $data['featuredproducts']=$featuredproducts;
         $latestproducts=Product::orderBy('id','DESC')->where('status','1')->take(8)->get();
         $data['latestproducts']=$latestproducts;
        return view('front.home',$data);
    }
}