<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController as ApiController;
use App\Http\Controllers\EventController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('events', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('events/print', [WebController::class, 'exportPrint'])->name('events.print');
    Route::get('events/pdf', [WebController::class, 'pdf'])->name('events.pdf');
    Route::get('events/csv', [WebController::class, 'csv'])->name('events.csv');
    Route::get('events/json', [WebController::class, 'json'])->name('events.json');
    Route::get('events/excel', [WebController::class, 'excel'])->name('events.excel');
    Route::get('events/import-excel-example', [WebController::class, 'importExcelExample'])->name('events.import-excel-example');
    Route::post('events/import-excel', [WebController::class, 'importExcel'])->name('events.import-excel');
    Route::resource('events', WebController::class);
});
