<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PrestasiController as ApiController;
use App\Http\Controllers\PrestasiController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('prestasis', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('prestasis/print', [WebController::class, 'exportPrint'])->name('prestasis.print');
    Route::get('prestasis/pdf', [WebController::class, 'pdf'])->name('prestasis.pdf');
    Route::get('prestasis/csv', [WebController::class, 'csv'])->name('prestasis.csv');
    Route::get('prestasis/json', [WebController::class, 'json'])->name('prestasis.json');
    Route::get('prestasis/excel', [WebController::class, 'excel'])->name('prestasis.excel');
    Route::get('prestasis/import-excel-example', [WebController::class, 'importExcelExample'])->name('prestasis.import-excel-example');
    Route::post('prestasis/import-excel', [WebController::class, 'importExcel'])->name('prestasis.import-excel');
    Route::resource('prestasis', WebController::class);
});
