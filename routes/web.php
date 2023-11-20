<?php

namespace App\Http\Controllers\Admin;

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

Route::get('/', function () {
    return view('auth.login');
});

/**
 * route for admin
 */

//group route with prefix "admin"
Route::prefix('admin')->group(function () {

    //group route with middleware "auth"
    Route::group(['middleware' => 'auth'], function() {
        
        //route dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
        //route category
        Route::resource('/category', CategoryController::class, ['as' => 'admin']);
        //route product
        Route::resource('/product', ProductController::class, ['as' => 'admin']);
        //route playlist
        Route::resource('/playlist', PlaylistController::class, ['as' => 'admin']);
        //route content
        Route::resource('/content', ContentController::class, ['as' => 'admin']);

        Route::post('/admin/content/approve/{id}', 'App\Http\Controllers\Admin\ContentController@approve')->name('admin.content.approve');

        //route order
        Route::resource('/order', OrderController::class, ['except' => ['create', 'store', 'edit', 'update', 'destroy'], 'as' => 'admin']);
        //route customer
        Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer.index');
        //route slider
        Route::resource('/slider', SliderController::class, ['except' => ['show', 'edit', 'update'], 'as' => 'admin']);
        //profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
        //route user
        Route::resource('/user', UserController::class, ['except' => ['show'], 'as' => 'admin']);
        //route putar
        Route::resource('/putar', PutarController::class, ['as' => 'admin']);
    });
});