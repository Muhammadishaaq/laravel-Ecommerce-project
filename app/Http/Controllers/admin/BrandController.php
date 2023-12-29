<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index(Request $request){
        $brands=Brand::latest();
        if(!empty($request->get('keyword'))){
            $brands=$brands->where('name','like','%'.$request->get('keyword').'%');

        }
        $brands=$brands->paginate(7);
        return view('admin.brand.list',compact('brands'));
    }

    public function create(){
        return view('admin.brand.create');
    }

    public function store(Request $request){
    //validate part
    $validator =$request->validate([
        'name'=>'required',
        'slug'=>'required|unique:brands',
        'status'=>'required'
        ]);
        $data =new Brand();
        $data->name=$request->input('name');
        $data->slug=$request->input('slug');
        $data->status=$request->input('status');
        $data->save();
        return redirect()->route('brands.index')->withSuccess('Brands added successfully!!!!');   
    }

    public function edit($id, Request $request){
        $data= Brand::where('id',$id)->first();
        if(empty($data)){
            return redirect()->route('brands.index');
        }
        return view('admin.brand.edit',compact('data'));
        
    }

    public function update($id, Request $request){
    //validate part
    $validator =$request->validate([
        $data=Brand::find($id),
        'name'=>'required',
        'slug'=>'required|unique:brands,slug,'.$data->id.',id',
        'status'=>'required'
        ]);
        $data->name=$request->input('name');
        $data->slug=$request->input('slug');
        $data->status=$request->input('status');
        $data->save();
        return redirect()->route('brands.index')->withSuccess('Brands updated successfully!!!!');   
    } 
    public function delete($id){
        Brand::destroy($id);
        return redirect()->route('brands.index')->withSuccess('Brands deleted successfully!!!!');  
    }
}
