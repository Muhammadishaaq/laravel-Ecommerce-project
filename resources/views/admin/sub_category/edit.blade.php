@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('sub-categories.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{route('sub-categories.update',$subcategory->id)}}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                    <option {{($subcategory->category_id==$category->id) ? 'selected':''}} value="{{$category->id}}">{{$category->name}}</option>   
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{$subcategory->name}}" id="name" class="form-control" placeholder="Name">	
                            </div>
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug"value="{{$subcategory->slug}}" class="form-control" placeholder="Slug">	
                            </div>
                            @if ($errors->has('slug'))
                            <span class="text-danger">{{ $errors->first('slug') }}</span>
                            @endif
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="showhome">Show On Home</label>
                                <select name="showhome" id="showhome" class="form-control">
                                    <option {{$subcategory->showhome=='Yes' ? 'selected': ''}} value="Yes">Yes</option>
                                    <option {{$subcategory->showhome=='No' ? 'selected': ''}} value="No">No</option>
                                </select>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{($subcategory->status==1) ? 'selected':''}} value="1">Active</option>
                                    <option {{($subcategory->status==0) ? 'selected':''}} value="0">Block</option>
                                </select>	
                            </div>
                        </div>									
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('sub-categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
       </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
   
@endsection

