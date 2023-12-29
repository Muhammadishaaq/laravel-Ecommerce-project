<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index(Request $request){
    $products=Product::latest('id')->with('product_images');
    if($request->get('keyword') !=""){
    $products= $products->where('title','like','%'.$request->keyword.'%');
    }
    $products=$products->paginate(7);
    $data['products']=$products;
    return view('admin.product.list',$data);
    }
    public function create( Request $request){
        $subcategories=SubCategory::orderBy('name','ASC')->get();
        $data['subcategories']=$subcategories;
        $categories=Category::orderBy('name','ASC')->get();
        $brands=Brand::orderBy('name','ASC')->get();
        $data['categories']=$categories;
        $data['brands']=$brands;
        return view('admin.product.create',$data);
    }
    public function store(Request $request){
        // Validate the form data
        $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:products',
        'description' => 'nullable|string',
        'images.*'=> 'required|mimes:jpg,png,jpeg|max:12300',
        'price' => 'required|numeric',
        'compare_price' => 'nullable|numeric',
        'sku' => 'nullable|string|max:255',
        'barcode' => 'nullable|string|max:255',
        'track_qty' => 'required|in:0,1',
        'qty' => 'required|integer|min:0',
        'status' => 'required|in:0,1',
        'is_featured' => 'required|in:0,1',
        'category_id' => 'required|exists:categories,id',
        'sub_category_id' => 'nullable|exists:sub_categories,id',
        'brand_id' => 'nullable|exists:brands,id',
    ]);

     $product = new Product;
    $product->title = $request->input('title');
    $product->slug = $request->input('slug');
    $product->description = $request->input('description');
    $product->price = $request->input('price');
    $product->compare_price = $request->input('compare_price');
    $product->sku = $request->input('sku');
    $product->barcode = $request->input('barcode');
    $product->track_qty = $request->input('track_qty');
    $product->qty = $request->input('qty');
    $product->status = $request->input('status');
    $product->is_featured = $request->input('is_featured');
    $product->category_id = $request->input('category_id');
    $product->sub_category_id = $request->input('sub_category_id');
    $product->brand_id = $request->input('brand_id');
    $product->save();
    
    if($request->images){
    foreach ($request->images as $image) {
    $modifiedImage=time().'-'.$image->getClientOriginalName();
    $image->move(public_path('/productimages'),$modifiedImage);
    $productimage=new ProductImage;
    $productimage->product_id=$product->id;
    $productimage->image=$modifiedImage;
    $productimage->save();
    }}
    return redirect()->route('products.index')->with('success', 'Product added successfully');   
    }
    public function edit($id , Request $request){
    $product=Product::find($id);
    if(empty($product)){
        return redirect()->route('products.index')->with('error','Product Not Founded !!');
    }
    //fetch product-images
    $productimages=ProductImage::where('product_id', $product->id)->get();
    $data=[];
    $data['product']=$product;
    $subcategories=SubCategory::orderBy('name','ASC')->get();
    $data['subcategories']=$subcategories;
    $categories=Category::orderBy('name','ASC')->get();
    $brands=Brand::orderBy('name','ASC')->get();
    $data['categories']=$categories;
    $data['brands']=$brands;
    $data['productimages']=$productimages;
    return view('admin.product.edit',$data);
    }
    public function update(Request $request, $id){
        $product =Product::find($id);
         $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|unique:products,slug,'.$product->id.',id',
        'description' => 'nullable|string',
        'images.*'=> 'required|mimes:jpg,png,jpeg|max:12300',
        'price' => 'required|numeric',
        'compare_price' => 'nullable|numeric',
        'sku' => 'nullable|unique:products,sku,'.$product->id.',id',
        'barcode' => 'nullable|string|max:255',
        'track_qty' => 'required|in:0,1',
        'qty' => 'required|integer|min:0',
        'status' => 'required|in:0,1',
        'is_featured' => 'required|in:0,1',
        'category_id' => 'required|exists:categories,id',
        'sub_category_id' => 'nullable|exists:sub_categories,id',
        'brand_id' => 'nullable|exists:brands,id',
    ]);
    $product->title = $request->input('title');
    $product->slug = $request->input('slug');
    $product->description = $request->input('description');
    $product->price = $request->input('price');
    $product->compare_price = $request->input('compare_price');
    $product->sku = $request->input('sku');
    $product->barcode = $request->input('barcode');
    $product->track_qty = $request->input('track_qty');
    $product->qty = $request->input('qty');
    $product->status = $request->input('status');
    $product->is_featured = $request->input('is_featured');
    $product->category_id = $request->input('category_id');
    $product->sub_category_id = $request->input('sub_category_id');
    $product->brand_id = $request->input('brand_id');
    $product->save();
    
    if($request->images){
    foreach ($request->images as $image) {
    $modifiedImage=time().'-'.$image->getClientOriginalName();
    $image->move(public_path('/productimages'),$modifiedImage);
    $productimage=new ProductImage;
    $productimage->product_id=$product->id;
    $productimage->image=$modifiedImage;
    $productimage->save();
    }}
    return redirect()->route('products.index')->with('success', 'Product Updated successfully');   
    }
    public function delete($id)
   {
    // Find the product
    $product = Product::findOrFail($id);

    // Manually delete associated product images
    $product->images()->delete();

    // Now you can safely delete the product
    $product->delete();

    return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
    
    
}