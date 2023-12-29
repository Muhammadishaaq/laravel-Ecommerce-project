@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('categories.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{route('categories.update',$data->id)}}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card">
                    <div class="card-body">								
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{$data->name}}" class="form-control" placeholder="Name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                     <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" value="{{$data->slug}}" class="form-control" placeholder="Slug" value="{{ old('slug') }}">
                                    @if ($errors->has('slug'))
                                     <span class="text-danger">{{ $errors->first('slug') }}</span>
                                    @endif	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br><input type="file" name="image"><br><br>
                                        </div>
                                    </div>
                                    @if ($errors->has('image'))
                                     <span class="text-danger">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                                @if (!empty($data->image))
                                <div>
                                    <img width='250' src="{{asset('category-image/'.$data->image)}}" alt="">
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="showhome">Show On Home</label>
                                    <select name="showhome" id="showhome" class="form-control">
                                        <option {{$data->showhome=='Yes' ? 'selected': ''}} value="Yes">Yes</option>
                                        <option {{$data->showhome=='No' ? 'selected': ''}} value="No">No</option>
                                    </select>	
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{$data->status=='1' ? 'selected': ''}} value="1">Active</option>
                                        <option {{$data->status=='0' ? 'selected': ''}} value="0">Block</option>
                                    </select>	
                                </div>
                            </div>										
                        </div>
                    </div>							
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{route('categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content --> 
@endsection

