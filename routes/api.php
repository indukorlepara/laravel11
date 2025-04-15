<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\ExportController;

Route::apiResource('posts', PostController::class);
Route::post('upload-image', [ImageController::class, 'uploadImage']);
Route::post('import-excel', [ExcelImportController::class, 'uploadExcel']);
Route::get('export-csv', [ExportController::class, 'exportCsv']);