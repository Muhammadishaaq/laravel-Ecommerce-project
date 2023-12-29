@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('products.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<form action="{{route('products.update',$product->id)}}" method="post" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title" value="{{$product->title}}" class="form-control" placeholder="Title">	
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" value={{$product->slug}} class="form-control" placeholder="Slug">	
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description">{{$product->description}}</textarea>
                                    </div>
                                </div>                                            
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>								
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">   
                                   <input type="file" name="images[]" class="form-control" multiple/>                                       
                                </div>
                            </div>
                            <div class="row">
                                @if($productimages->isNotEmpty())
                                @foreach ($productimages as $image )
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="{{asset('productimages/'.$image->image)}}" alt="">
                                    </div>
                                    
                                </div> 
                                @endforeach
                                @endif 
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input type="number" name="price" id="price" value={{$product->price}} class="form-control" placeholder="Price">	
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="number" name="compare_price" id="compare_price" value={{$product->compare_price}} class="form-control" placeholder="Compare Price">
                                        <p class="text-muted mt-3">
                                            To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                        </p>	
                                    </div>
                                </div>                                            
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>								
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" value={{$product->sku}} id="sku" class="form-control" placeholder="sku">	
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" value={{$product->barcode}} class="form-control" placeholder="Barcode">	
                                    </div>
                                </div>   
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="track_qty">Track-qty</label>
                                        <select name="track_qty" id="track_qty" class="form-control">
                                            <option {{($product->track_qty==1)? 'selected':''}} value="1">Yes</option>
                                            <option {{($product->track_qty==0)? 'selected':''}} value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="number" min="0" value={{$product->qty}} name="qty" id="qty" class="form-control" placeholder="Qty">	
                                    </div>
                                </div>                                         
                            </div>
                        </div>	                                                                      
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option {{($product->status==1)? 'selected':''}} value="1">Active</option>
                                    <option {{($product->status==0)? 'selected':''}} value="0">Block</option>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Product category</h2>
                            <div class="mb-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Select a Category</option>
                                    @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category_id)
                                        <option {{($product->category_id==$category_id->id)? "selected":""}} value="{{$category_id->id}}">{{$category_id->name}}</option>
                                    @endforeach   
                                    @endif
                                    
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="sub_category_id">Sub category</label>
                                <select name="sub_category_id" id="sub_category_id" class="form-control">
                                    <option value="">Select a Sub-Category</option>
                                    @if ($subcategories->isNotEmpty())
                                    @foreach ($subcategories as $sub_category_id)
                                        <option {{($product->sub_category_id==$sub_category_id->id)? "selected":""}} value="{{$sub_category_id->id}}">{{$sub_category_id->name}}</option>
                                    @endforeach   
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product brand</h2>
                            <div class="mb-3">
                                <select name="brand_id" id="brand_id" class="form-control">
                                    <option value="">Select a Brand</option>
                                    @if ($brands->isNotEmpty())
                                    @foreach ($brands as $brand_id)
                                        <option {{($product->brand_id==$brand_id->id)?"selected":""}} value="{{$brand_id->id}}">{{$brand_id->name}}</option>
                                    @endforeach    
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Featured product</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option {{($product->is_featured==0)? 'selected':''}}  value="0">No</option>
                                    <option {{($product->is_featured==1)? 'selected':''}} value="1">Yes</option>                                                
                                </select>
                            </div>
                        </div>
                    </div>                                 
                </div>
            </div>
            
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('products.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
        <!-- /.card -->
    </section>
</form>
<!-- /.content -->
    
@endsection