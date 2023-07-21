<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PageHomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\AjaxController;

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
Route::group(['middleware'=>'site.setting'], function (){

    Route::get('/', [PageHomeController::class, 'homePage'])->name('homePage');


    Route::get('/products', [PageController::class, 'products'])->name('products');

    Route::get('/products/men', [PageController::class, 'products'])->name('men');

    Route::get('/products/women', [PageController::class, 'products'])->name('women');

    Route::get('/products/kids', [PageController::class, 'products'])->name('kids');

    Route::get('/products/{slug}', [PageController::class, 'proDetail'])->name('proDetail');


    Route::get('/aboutUs', [PageController::class, 'aboutUs'])->name('aboutUs');

    Route::get('/contact', [PageController::class, 'contact'])->name('contact');

    Route::post('contact', [AjaxController::class, 'contactSave'])->name('contactSave');

    Route::get('/cart', [PageController::class, 'cart'])->name('cart');

    Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');

    Route::get('/thankYou', [PageController::class, 'thankYou'])->name('thankYou');

});
