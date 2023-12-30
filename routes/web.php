<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('/product', 'App\Http\Controllers\ProductController');
    Route::resource('/customer-details', 'App\Http\Controllers\CustomerController');
    Route::resource('/bill', 'App\Http\Controllers\BillController');
    Route::resource('/system-settings/company-details', 'App\Http\Controllers\CompanyDetailController')->only('index', 'store');
    Route::get('/bill/{id}/download', 'App\Http\Controllers\BillController@downloadBill')->name('bill_download');
    Route::get('/get-products', 'App\Http\Controllers\ProductController@getProducts');
    Route::get('/get-holiday-dates', 'App\Http\Controllers\BillController@getHolidayDates')->name('get_holiday_dates');
});

require __DIR__.'/auth.php';
