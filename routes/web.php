<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[FrontController::class,'index'])->name('front.home');
Route::get('/shop/{categorySlug?}/{subCategorySlug?}',[ShopController::class,'index'])->name('front.shop');

Route::group(['prefix'=>'admin'], function(){
    Route::group(['middleware'=>'admin.guest'], function(){
        Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');

    });
    Route::group(['middleware'=>'admin.auth'], function(){
        Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');
        Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');

        //Categories Routes
        Route::get('/categories/index',[CategoryController::class,'index'])->name('categories.index');
        Route::get('/categories/create',[CategoryController::class,'create'])->name('categories.create');
        Route::get('/categories/{id}/edit',[CategoryController::class,'edit'])->name('categories.edit');
        Route::put('/categories/{id}/update',[CategoryController::class,'update'])->name('categories.update');
        Route::get('/categories/{id}/delete',[CategoryController::class,'delete'])->name('categories.delete');
        Route::post('/categories/store',[CategoryController::class,'store'])->name('categories.store');

        //Sub-category Routes
        Route::get('/sub-categories/index',[SubCategoryController::class,'index'])->name('sub-categories.index');
        Route::get('/sub-categories/create',[SubCategoryController::class,'create'])->name('sub-categories.create');
        Route::post('/sub-categories/store',[SubCategoryController::class,'store'])->name('sub-categories.store');
        Route::get('/sub-categories/{id}/edit',[SubCategoryController::class,'edit'])->name('sub-categories.edit');
        Route::get('/sub-categories/{id}/delete',[SubCategoryController::class,'delete'])->name('sub-categories.delete');
        Route::put('/sub-categories/{id}/update',[SubCategoryController::class,'update'])->name('sub-categories.update');

        //Brands Routes
        Route::get('/brands/index',[BrandController::class,'index'])->name('brands.index');
        Route::get('/brands/create',[BrandController::class,'create'])->name('brands.create');
        Route::get('/brands/{id}/edit',[BrandController::class,'edit'])->name('brands.edit');
        Route::put('/brands/{id}/update',[BrandController::class,'update'])->name('brands.update');
        Route::get('/brands/{id}/delete',[BrandController::class,'delete'])->name('brands.delete');
        Route::post('/brands/store',[BrandController::class,'store'])->name('brands.store');

        //Product Routes
        Route::get('/products/index',[ProductController::class,'index'])->name('products.index');
        Route::get('/products/create',[ProductController::class,'create'])->name('products.create');
        Route::post('/products/store',[ProductController::class,'store'])->name('products.store');
        Route::get('/products/{id}/edit',[ProductController::class,'edit'])->name('products.edit');
        Route::put('/products/{id}/update',[ProductController::class,'update'])->name('products.update');
        Route::get('/products/{id}/delete',[ProductController::class,'delete'])->name('products.delete');

       


    });
});