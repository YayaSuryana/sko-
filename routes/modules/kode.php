<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KodeController as ApiController;
use App\Http\Controllers\KodeController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('ProfileatletController', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('kodes/print', [WebController::class, 'exportPrint'])->name('kodes.print');
    Route::get('kodes/pdf', [WebController::class, 'pdf'])->name('kodes.pdf');
    Route::get('kodes/csv', [WebController::class, 'csv'])->name('kodes.csv');
    Route::get('kodes/json', [WebController::class, 'json'])->name('kodes.json');
    Route::get('kodes/excel', [WebController::class, 'excel'])->name('kodes.excel');
    Route::get('kodes/import-excel-example', [WebController::class, 'importExcelExample'])->name('kodes.import-excel-example');
    Route::post('kodes/import-excel', [WebController::class, 'importExcel'])->name('kodes.import-excel');
    Route::resource('kode', WebController::class);
});
