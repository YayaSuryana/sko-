<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MastereventController as ApiController;
use App\Http\Controllers\MastereventController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('masterevents', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('masterevents/print', [WebController::class, 'exportPrint'])->name('masterevents.print');
    Route::get('masterevents/pdf', [WebController::class, 'pdf'])->name('masterevents.pdf');
    Route::get('masterevents/csv', [WebController::class, 'csv'])->name('masterevents.csv');
    Route::get('masterevents/json', [WebController::class, 'json'])->name('masterevents.json');
    Route::get('masterevents/excel', [WebController::class, 'excel'])->name('masterevents.excel');
    Route::get('masterevents/import-excel-example', [WebController::class, 'importExcelExample'])->name('masterevents.import-excel-example');
    Route::post('masterevents/import-excel', [WebController::class, 'importExcel'])->name('masterevents.import-excel');
    Route::resource('masterevents', WebController::class);
});
