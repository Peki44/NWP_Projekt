<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;

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

// Route::get('/admin', [AdminController::class,'admin']);

Route::group(['middleware'=>'auth'],function(){
    Route::get('/addcategory', [CategoryController::class,'addcategory']);
    Route::get('/categories', [CategoryController::class,'categories']);
    Route::post('/savecategory', [CategoryController::class,'savecategory']);
    Route::get('/editcategory/{id}', [CategoryController::class,'editcategory']);
    Route::post('/updatecategory', [CategoryController::class,'updatecategory']);
    Route::get('/deletecategory/{id}', [CategoryController::class,'deletecategory']);

    Route::get('/addslider', [SliderController::class,'addslider']);
    Route::get('/sliders', [SliderController::class,'sliders']);
    Route::post('/saveslider', [SliderController::class,'saveslider']);
    Route::get('/editslider/{id}', [SliderController::class,'editslider']);
    Route::post('/updateslider', [SliderController::class,'updateslider']);
    Route::get('/deleteslider/{id}', [SliderController::class,'deleteslider']);
    Route::get('/activateslider/{id}', [SliderController::class,'activateslider']);
    Route::get('/unactivateslider/{id}', [SliderController::class,'unactivateslider']);


    Route::get('/addproduct', [ProductController::class,'addproduct']);
    Route::get('/products', [ProductController::class,'products']);
    Route::get('/editproduct/{id}', [ProductController::class,'editproduct']);
    Route::post('/saveproduct', [ProductController::class,'saveproduct']);
    Route::post('/updateproduct', [ProductController::class,'updateproduct']);
    Route::get('/deleteproduct/{id}', [ProductController::class,'deleteproduct']);
    Route::get('/activateproduct/{id}', [ProductController::class,'activateproduct']);
    Route::get('/unactivateproduct/{id}', [ProductController::class,'unactivateproduct']);
    Route::get('/view_product_by_category/{category_name}', [ProductController::class,'view_product_by_category']);

    Route::get('/', [ClientController::class,'home']);
    Route::get('/shop',[ClientController::class,'shop']);
    Route::get('/cart',[ClientController::class,'cart']);
    Route::get('/checkout',[ClientController::class,'checkout']);
    Route::get('/login1',[ClientController::class,'login']);
    Route::get('/signup',[ClientController::class,'signup']);
    Route::post('/create_account',[ClientController::class,'create_account']);
    Route::post('/access_account',[ClientController::class,'access_account']);
    Route::get('/logout',[ClientController::class,'logout']);
    Route::get('/orders',[ClientController::class,'orders']);

});


Route::get('/admin', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

