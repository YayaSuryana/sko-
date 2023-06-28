<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AtletController as ApiController;
use App\Http\Controllers\AtletController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('AtletController', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('atlets/print', [WebController::class, 'exportPrint'])->name('atlets.print');
    Route::get('atlets/pdf', [WebController::class, 'pdf'])->name('atlets.pdf');
    Route::get('atlets/csv', [WebController::class, 'csv'])->name('atlets.csv');
    Route::get('atlets/json', [WebController::class, 'json'])->name('atlets.json');
    Route::get('atlets/excel', [WebController::class, 'excel'])->name('atlets.excel');
    Route::get('atlets/import-excel-example', [WebController::class, 'importExcelExample'])->name('atlets.import-excel-example');
    Route::post('atlets/import-excel', [WebController::class, 'importExcel'])->name('atlets.import-excel');
    Route::resource('atlets', WebController::class);
});
