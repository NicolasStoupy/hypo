<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PoneyController;
use App\Http\Controllers\PoneyControllerCrud;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;


Auth::routes();


Route::middleware([App\Http\Middleware\Auth::class, 'auth'])->group(function () {

    // Home page
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home', [HomeController::class, 'index']);

    // Routes pour les resources
    Route::resource('/poney', PoneyController::class);
    Route::resource('/client', ClientController::class);
    Route::resource('/evenement', EvenementController::class);

    Route::get('/facture/gestion',[FactureController::class,'gestion'])->name('facturier');
    Route::resource('/facture', FactureController::class);
    Route::resource('/gestion', GestionController::class);
    Route::resource('/status', StatusController::class);
    Route::resource('/gestion',GestionController::class);

    // Routes pour les graphiques
    Route::get('/chart/event', [ChartController::class, 'getEventChart']);
    Route::get('/chart/poney', [ChartController::class, 'getPoneyChart']);

    // Routes spécifiques
    Route::post('/selectPoney', [GestionController::class, 'selectPoney'])->name('selectPoney');
    Route::post('/updatePoney', [GestionController::class, 'updatePoney'])->name('updatePoney');
});
