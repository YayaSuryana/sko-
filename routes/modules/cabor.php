<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CaborController as ApiController;
use App\Http\Controllers\CaborController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('cabors', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('cabors/print', [WebController::class, 'exportPrint'])->name('cabors.print');
    Route::get('cabors/pdf', [WebController::class, 'pdf'])->name('cabors.pdf');
    Route::get('cabors/csv', [WebController::class, 'csv'])->name('cabors.csv');
    Route::get('cabors/json', [WebController::class, 'json'])->name('cabors.json');
    Route::get('cabors/excel', [WebController::class, 'excel'])->name('cabors.excel');
    Route::get('cabors/import-excel-example', [WebController::class, 'importExcelExample'])->name('cabors.import-excel-example');
    Route::post('cabors/import-excel', [WebController::class, 'importExcel'])->name('cabors.import-excel');
    Route::resource('atlets', WebController::class);
});
