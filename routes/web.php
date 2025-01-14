<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfController;
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

    Route::get('/facture/gestion', [FactureController::class, 'gestion'])->name('facturier');
    Route::resource('/facture', FactureController::class);
    Route::resource('/gestion', GestionController::class);
    Route::resource('/status', StatusController::class);
    Route::post('/gestion/type', [GestionController::class, 'evenement_type_choiced'])->name('evenement_choiced');
    Route::post('/gestion/newevent', [GestionController::class, 'new_event'])->name('new_event');

    // Routes pour les graphiques json
    Route::get('/chart/event', [ChartController::class, 'get_event_chart']);
    Route::get('/chart/poney', [ChartController::class, 'get_poney_chart']);


    // Routes pour pdf
    Route::get('/pdf/facture', [PdfController::class, 'facture']);
    // Routes spécifiques
    Route::post('/select_poney', [GestionController::class, 'selectPoney'])->name('select_poney');
    Route::post('/update_poney', [GestionController::class, 'updatePoney'])->name('update_poney');
});
