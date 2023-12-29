<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug=null, $subCategorySlug=null){
        $categorySelected="";
        $subCategorySelected="";
        $brandsArray=[];
        $categories=Category::orderBy('name','ASC')->with('sub_category')->where('status',1)->get();
        $brands=Brand::orderBy('name','ASC')->where('status',1)->get();
        $products=Product::where('status','1');
        //apply fliter here
        if(!empty($categorySlug)){
        $category=Category::where('slug',$categorySlug)->first();
        $product=$products->where('category_id',$category->id);
        $categorySelected=$category->id;
        }
        if(!empty($subCategorySlug)){
        $subcategory=SubCategory::where('slug',$subCategorySlug)->first();
        $product=$products->where('sub_category_id',$subcategory->id);
        $subCategorySelected=$subcategory->id;
        }
        if(!empty($request->get('brand'))){
            $brandsArray=explode(',', $request->get('brand'));
            $products=$products->whereIn('brand_id', $brandsArray);
        }
        $products=$products->orderBy('id','DESC');
        $products=$products->get();
        $data['categories']=$categories;
        $data['brands']=$brands;
        $data['products']=$products;
        $data['categorySelected']=$categorySelected;
        $data['subCategorySelected']=$subCategorySelected;
        $data['brandsArray']=$brandsArray;
        return view('front.shop',$data);
    }
}