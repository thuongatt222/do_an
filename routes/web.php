<?php

use App\Http\Controllers\PusherController;
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
    return view('front.home');
})->name('home');
Route::get('/cart', function(){
    return view('front.cart');
})->name('cart');
Route::get('/tracking', function(){
    return view('front.tracking');
})->name('tracking');
Route::get('/contact', function(){
    return view('front.contact');
})->name('contact');
Route::get('/category', function(){
    return view('front.category');
})->name('category');
Route::get('/blog', function(){
    return view('front.blog');
})->name('blog');
Route::get('/element', function(){
    return view('front.elements');
})->name('element');
Route::get('/s-blog', function(){
    return view('front.single-blog');
})->name('blogs');
Route::get('/product', function(){
    return view('front.single-product');
})->name('product');
Route::get('/checkout', function(){
    return view('front.checkout');
})->name('checkout');
Route::get('/test', function () {
    return view('dashboard.pages.samples.login');
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
Route::post('/broadcast', [PusherController::class, 'broadcast']);
Route::post('/receive', [PusherController::class, 'receive']);
Route::get('/chat', [PusherController::class, 'index']);