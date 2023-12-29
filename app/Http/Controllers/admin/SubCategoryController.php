<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index(Request $request){
        $subcategories=SubCategory::select('sub_categories.*','categories.name as categoryName')->latest('sub_categories.id')->leftJoin('categories','categories.id','sub_categories.category_id');
        if(!empty($request->get('keyword'))){
        $subcategories=$subcategories->where('sub_categories.name','like','%'.$request->get('keyword').'%');
        }
        $subcategories=$subcategories->paginate(7);
        return view('admin.sub_category.list',compact('subcategories'));
    }

    public function create(){
        $categories=Category::orderBy('name','ASC')->get();
        return view('admin.sub_category.create',compact('categories'));
    }
    public function store(Request $request){
        //validate part
        $validator =$request->validate([
        'name'=>'required',
        'slug'=>'required|unique:sub_categories',
        'category'=>'required',
        'status'=>'required'
        ]);
        $data =new SubCategory();
        $data->name=$request->input('name');
        $data->slug=$request->input('slug');
        $data->category_id=$request->input('category');
        $data->status=$request->input('status');
        $data->showhome=$request->input('showhome');
        $data->save();
        return redirect()->route('sub-categories.index')->withSuccess('Category added successfully!!!!');   
    }

    public function edit($id, Request $request){
        $subcategory=SubCategory::find($id);
        if(empty($subcategory)){
        return redirect()->route('sub-categories.index');
        }
        $categories=Category::orderBy('name','ASC')->get();
        $data['categories']=$categories;
        $data['subcategory']=$subcategory;
        return view('admin.sub_category.edit',$data);
        
    }
    
    public function update($id, Request $request){
        //validate part
        $validator =$request->validate([
        $data= SubCategory::where('id',$id)->first(),
        'name'=>'required',
        'slug'=>'required|unique:categories,slug,'.$data->id.',id',
        'category'=>'required',
        'status'=>'required'
        ]);
        $data->name=$request->input('name');
        $data->slug=$request->input('slug');
        $data->category_id=$request->input('category');
        $data->status=$request->input('status');
        $data->showhome=$request->input('showhome');
        $data->save();
        return redirect()->route('sub-categories.index')->withSuccess('Sub-category updated successfully!!!!');  

    }

    public function delete($id){
        SubCategory::destroy($id);
        return back();
    }
}