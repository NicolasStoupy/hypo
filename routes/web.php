<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PoneyController;
use App\Http\Controllers\PoneyControllerCrud;
use Illuminate\Support\Facades\Route;


Auth::routes();

//Route::get('', [App\Http\Controllers\EmployeeController::class, 'index'])->name('home')->middleware([App\Http\Middleware\Auth::class, 'auth']);
//Route::get('/home', [App\Http\Controllers\EmployeeController::class, 'index'])->name('home')->middleware([App\Http\Middleware\Auth::class, 'auth']);

//Route::get('/employee', [App\Http\Controllers\EmployeeController::class, 'index'])
//    ->name('employee')
//    ->middleware([App\Http\Middleware\Auth::class, 'auth']);
//Route::resource('employees', EmployeeController::class)->middleware([App\Http\Middleware\Auth::class, 'auth']);

Route::get('/home', [HomeController::class, 'index']);
Route::resource('/poney', PoneyController::class);
Route::resource('/client', ClientController::class  );
//Route::resource('poney', \App\Http\Controllers\CRUD\PoneyController::class);
Route::resource('evenement', EvenementController::class);
Route::resource('facture', FactureController::class);
