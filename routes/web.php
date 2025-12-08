<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResourceController;

Route::get('/', function () {
    return view('welcome');
});

// Demo PDF (veritabanı olmadan test)
Route::get('/pdf/demo', [ResourceController::class, 'downloadDemoPdf'])->name('pdf.demo');

// Resource CRUD routes
Route::resource('resources', ResourceController::class);

// PDF indirme
Route::get('/resources/{resource}/pdf', [ResourceController::class, 'downloadPdf'])->name('resources.pdf');
