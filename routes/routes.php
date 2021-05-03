<?php

use Illuminate\Support\Facades\Route;
use Thotam\ThotamBuddy\Http\Controllers\BuddyCaNhanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['web', 'auth', 'CheckAccount', 'CheckHr'])->group(function () {

    //Route Buddy
    Route::redirect('buddy', '/', 301);
    Route::group(['prefix' => 'buddy'], function () {

        //Route quản lý người dùng
        Route::get('canhan',  [BuddyCaNhanController::class, 'index'])->name('buddy.canhan');

    });

});
