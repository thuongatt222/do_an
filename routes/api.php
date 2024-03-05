<?php

use App\Http\Controllers\size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});
Route::prefix('size')->group(function () {
        Route::get('show', [size::class, 'index'])->name('size');
        Route::post('update', [size::class, 'update'])->name('size_update');
        Route::post('insert', [size::class, 'store'])->name('size_insert');
        Route::post('destroy', [size::class, 'destroy'])->name('size_destroy');
    });