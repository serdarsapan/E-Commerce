<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\SliderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;



/*
|--------------------------------------------------------------------------
| Panel Routes
|--------------------------------------------------------------------------
|
| Here is where you can register panel routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "panel" middleware group. Make something great!
|
*/

Route::group(['middleware'=>['panel.setting','auth'], 'as'=>'dashboard.'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');
    Route::get('/slider/create', [SliderController::class, 'create'])->name('slider.create');
    Route::get('/slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
    Route::post('/slider/store', [SliderController::class, 'store'])->name('slider.store');
    Route::put('/slider/{id}/update', [SliderController::class, 'update'])->name('slider.update');
    Route::delete('/slider/destroy', [SliderController::class, 'destroy'])->name('slider.destroy');
    Route::post('/slider-case/update', [SliderController::class, 'status'])->name('slider.status');

    Route::resource('/category', CategoryController::class)->except('destroy');
    Route::delete('/category/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::post('/category-case/update', [CategoryController::class, 'status'])->name('category.status');

    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/contact/{id}/edit', [ContactController::class, 'edit'])->name('contact.edit');
    Route::get('/contact/{id}/update', [ContactController::class, 'update'])->name('contact.update');
    Route::delete('contact/destroy', [ContactController::class, 'destroy'])->name('contact.destroy');
    Route::post('/contact-case/update', [CategoryController::class, 'status'])->name('contact.status');
});
