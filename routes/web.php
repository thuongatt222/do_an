<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard.index');
});
Route::get('/auth/facebook/callback', function () {
    $facebookUser = Socialite::driver('facebook')->user();
});
Route::get('/auth/facebook', function () {
    return Socialite::driver('facebook')->redirect();
});
Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();
    dd($googleUser);
});
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});