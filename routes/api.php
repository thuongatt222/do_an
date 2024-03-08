<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Resources\SizeConllection;
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
// Route::prefix('size')->group(function () {
//     Route::get('show', [SizeController::class, 'index'])->name('size_show');
//     Route::post('update', [SizeController::class, 'update'])->name('size_update');
//     Route::post('insert', [SizeController::class, 'store'])->name('size_insert');
//     Route::post('destroy', [SizeController::class, 'destroy'])->name('size_destroy');
// });
Route::apiResource('size', SizeController::class);
Route::apiResource('brand', BrandController::class);
Route::apiResource('product', ProductController::class);
Route::apiResource('category', CategoryController::class);
Route::apiResource('color', ColorController::class);
