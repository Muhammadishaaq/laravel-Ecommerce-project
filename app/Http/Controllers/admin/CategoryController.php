<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories=Category::latest();
        if(!empty($request->get('keyword'))){
            $categories=$categories->where('name','like','%'.$request->get('keyword').'%');

        }
        $categories=$categories->paginate(7);
        return view('admin.category.list',compact('categories'));

    }

    public function create(){
        return view ('admin.category.create');
      
    }

    public function store(Request $request){
        //validate part
        $validator =$request->validate([
        'name'=>'required',
        'slug'=>'required|unique:categories',
        'image'=>'required|mimes:png,jpg,jpeg|max:10000'
        ]);
        //upload image
        $imageName=time().'.'.$request->image->extension();
        $request->image->move(public_path('category-image'), $imageName);
        $data =new Category();
        $data->image=$imageName;
        $data->name=$request->input('name');
        $data->slug=$request->input('slug');
        $data->status=$request->input('status');
        $data->showhome=$request->input('showhome');
        $data->save();
        return redirect()->route('categories.index')->withSuccess('Category added successfully!!!!');   
    }

    public function edit($id, Request $request){
        $data= Category::where('id',$id)->first();
        if(empty($data)){
            return redirect()->route('categories.index');
        }
        return view('admin.category.edit',compact('data'));
        
    }

    public function update($id,Request $request){
         //validate part
        $request->validate([ 
        $data= Category::where('id',$id)->first(),
        'name'=>'required',
        'slug'=>'required|unique:categories,slug,'.$data->id.',id',
        'image'=>'nullable|mimes:png,jpg,jpeg|max:10000'
        ]);
        if(isset($request->image)){
        //upload image
        $imageName=time().'.'.$request->image->extension();
        $request->image->move(public_path('category-image'), $imageName);
        $data->image=$imageName;
        }
        $data->name=$request->name;
        $data->slug=$request->slug;
        $data->status=$request->status;
        $data->showhome=$request->input('showhome');
        $data->save();
        return redirect()->route('categories.index')->withSuccess('Category Updated Successfully !!!!'); 
        
    
    }
        
    public function delete($id){
        Category::destroy($id);
        return back();
    }
}