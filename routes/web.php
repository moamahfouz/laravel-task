<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;


Route::get('/', [FileController::class, 'index']);
Route::post('/upload', [FileController::class, 'upload'])->name('upload');
Route::post('/encrypt', [FileController::class, 'encrypt'])->name('encrypt');
Route::post('/decrypt', [FileController::class, 'decrypt'])->name('decrypt');
