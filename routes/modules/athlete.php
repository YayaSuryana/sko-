<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AthleteController as ApiController;
use App\Http\Controllers\AthleteController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('athletes', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('athletes/print', [WebController::class, 'exportPrint'])->name('athletes.print');
    Route::get('athletes/pdf', [WebController::class, 'pdf'])->name('athletes.pdf');
    Route::get('athletes/csv', [WebController::class, 'csv'])->name('athletes.csv');
    Route::get('athletes/json', [WebController::class, 'json'])->name('athletes.json');
    Route::get('athletes/excel', [WebController::class, 'excel'])->name('athletes.excel');
    Route::get('athletes/import-excel-example', [WebController::class, 'importExcelExample'])->name('athletes.import-excel-example');
    Route::post('athletes/import-excel', [WebController::class, 'importExcel'])->name('athletes.import-excel');
    Route::resource('athletes', WebController::class);
});
