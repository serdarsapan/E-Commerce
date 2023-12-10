<?php


use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PageHomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

    Route::get('/products/men/{slug?}', [PageController::class, 'products'])->name('men');

    Route::get('/products/women/{slug?}', [PageController::class, 'products'])->name('women');

    Route::get('/products/kids/{slug?}', [PageController::class, 'products'])->name('kids');

    Route::get('/products/{slug}', [PageController::class, 'proDetail'])->name('proDetail');


    Route::get('/aboutUs', [PageController::class, 'aboutUs'])->name('aboutUs');

    Route::get('/contact', [PageController::class, 'contact'])->name('contact');

    Route::post('contact', [AjaxController::class, 'contactSave'])->name('contactSave');

    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::get('/thankYou', [PageController::class, 'thankYou'])->name('thankYou');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/coupon', [CartController::class, 'coupon'])->name('coupon.check');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/newQty', [CartController::class, 'newQty'])->name('cart.newQty');
    Route::post('/cart/save', [CartController::class, 'cartSave'])->name('cart.cartSave');

    Auth::routes();
    Route::get('/login',[CustomAuthController::class, 'login'])->name('login');

    Route::get('/logout',[CustomAuthController::class, 'logouts'])->name('logouts');
});
