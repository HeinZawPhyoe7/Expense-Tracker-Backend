<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseTrackerController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::get('/user', [AuthController::class, 'user'])->middleware('auth:api')->name('user');

    //Expense
    Route::post('/expense/store', [ExpenseTrackerController::class, 'store'])->name('expense-store');
    Route::get('/expense/getall', [ExpenseTrackerController::class, 'getall'])->name('expense-getall');
});
