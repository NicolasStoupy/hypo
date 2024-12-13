<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('', [App\Http\Controllers\EmployeeController::class, 'index'])->name('home')->middleware([App\Http\Middleware\Auth::class, 'auth']);
Route::get('/home', [App\Http\Controllers\EmployeeController::class, 'index'])->name('home')->middleware([App\Http\Middleware\Auth::class, 'auth']);

Route::get('/employee', [App\Http\Controllers\EmployeeController::class, 'index'])
    ->name('employee')
    ->middleware([App\Http\Middleware\Auth::class, 'auth']);
Route::resource('employees', EmployeeController::class)->middleware([App\Http\Middleware\Auth::class, 'auth']);
