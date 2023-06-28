<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileatletController as ApiController;
use App\Http\Controllers\ProfileatletController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('ProfileatletController', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('profileatlets/print', [WebController::class, 'exportPrint'])->name('profileatlets.print');
    Route::get('profileatlets/pdf', [WebController::class, 'pdf'])->name('profileatlets.pdf');
    Route::get('profileatlets/csv', [WebController::class, 'csv'])->name('profileatlets.csv');
    Route::get('profileatlets/json', [WebController::class, 'json'])->name('profileatlets.json');
    Route::get('profileatlets/excel', [WebController::class, 'excel'])->name('profileatlets.excel');
    Route::get('profileatlets/import-excel-example', [WebController::class, 'importExcelExample'])->name('profileatlets.import-excel-example');
    Route::post('profileatlets/import-excel', [WebController::class, 'importExcel'])->name('profileatlets.import-excel');
    Route::resource('profileatlets', WebController::class);
});
