<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
//     return view('pages.index');
// });


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(App\Http\Controllers\Frontend\FrontendController::class)->group(function() {
    Route::get('/','index')->name('index');
    Route::get('products','products')->name('frontend.products');
    Route::get('product/{slug}','productShow')->name('frontend.product.show');

    Route::get('product-add-cart','productAddCart')->name('frontend.product.add.cart')
        ->middleware('auth');

    Route::get('orders','orders')->name('frontend.orders');

    Route::get('contact', 'contact')->name('frontend.contact');
    Route::post('contact', 'contactStore')->name('frontend.contact.store');

});

Route::controller(\App\Http\Controllers\Frontend\CartController::class)->middleware('auth')->group(function() {
    Route::get('cart','index')->name('cart');
    Route::post('add-cart/{id}', 'store')->name('add-cart');
    Route::post('update-cart', 'update')->name('update-cart');
    Route::post('remove-cart', 'destroy')->name('remove-cart-item');

});

Route::controller(\App\Http\Controllers\Frontend\CheckoutController::class)->middleware('auth')->group(function() {

    Route::get('checkout', 'index')->name('checkout');
    Route::post('checkout', 'store')->name('checkout-store');
});

Route::controller(\App\Http\Controllers\Frontend\OrderController::class)->middleware('auth')->group(function() {

    Route::get('orders', 'index')->name('frontend.orders');
});

Route::prefix('admin')->group(function() {

    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);

    Route::controller(App\Http\Controllers\Admin\CategoryController::class)->group(function() {
        Route::get('/category', 'index');
        Route::get('/category/create', 'create');
        Route::post('category', 'store');
        Route::get('category/edit/{id}','edit');
        Route::put('category/{id}', 'update');
        Route::get('category/delete/{id}', 'destroy');
    });


    Route::controller(\App\Http\Controllers\Admin\BrandController::class)->group(function () {
        Route::get('brand', 'index');
        Route::get('brand/create', 'create');
        Route::post('brand', 'store');
        Route::get('brand/edit/{id}', 'edit');
        Route::put('brand/{id}', 'update');
        Route::get('brand/delete/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\Admin\SubCategoryController::class)->group(function() {
        Route::get('subcategory', 'index');
        Route::get('subcategory/create', 'create');
        Route::post('subcategory', 'store');
        Route::get('subcategory/edit/{id}', 'edit');
        Route::put('subcategory/{id}', 'update');
        Route::get('subcategory/delete/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\Admin\ProductController::class)->group(function() {
        Route::get('product', 'index');
        Route::get('product/create', 'create');
        Route::post('product', 'store');
        Route::get('product/edit/{id}', 'edit');
        Route::put('product/{id}', 'update');
        Route::delete('product/delete/{id}', 'destroy');

        Route::get('product/image/{id}', 'showImage');
        Route::post('product/image/{id}', 'storeImage');
        Route::delete('product/image/delete/{id}', 'removeImage');
    });

    Route::controller(\App\Http\Controllers\Admin\SliderController::class)->group(function() {
        Route::get('slider', 'index');
        Route::get('slider/create', 'create');
        Route::post('slider', 'store');
        Route::get('slider/edit/{id}', 'edit');
        Route::put('slider/{id}', 'update');
        Route::get('slider/delete/{id}', 'destroy');
    });

    Route::controller(App\Http\Controllers\Admin\ContactController::class)->group(function() {
        Route::get('/contact', 'index');
        Route::delete('/contact/delete/{id}', 'destroy');
    });


});
