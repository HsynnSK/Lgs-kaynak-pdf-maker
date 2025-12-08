<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PdfResourceController;
use App\Http\Controllers\Api\ImageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// PDF Resource API Routes
Route::prefix('pdf-resources')->group(function () {
    Route::get('/', [PdfResourceController::class, 'index']);
    Route::post('/', [PdfResourceController::class, 'store']);
    Route::get('/demo-pdf', [PdfResourceController::class, 'demoPdf']);
    Route::get('/{id}', [PdfResourceController::class, 'show']);
    Route::put('/{id}', [PdfResourceController::class, 'update']);
    Route::delete('/{id}', [PdfResourceController::class, 'destroy']);
    Route::get('/{id}/pdf', [PdfResourceController::class, 'downloadPdf']);
});

// Image Upload API Routes
Route::prefix('images')->group(function () {
    Route::get('/', [ImageController::class, 'index']);
    Route::post('/upload', [ImageController::class, 'upload']);
    Route::post('/upload-multiple', [ImageController::class, 'uploadMultiple']);
    Route::delete('/', [ImageController::class, 'destroy']);
});
