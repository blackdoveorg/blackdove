<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerchJSON;
use App\Http\Controllers\PeckJSON;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/perch', function () {
    return view('perch');
})->name('dashboard-perch');

Route::middleware(['auth:sanctum', 'verified'])->get('/peck', function () {
    return view('peck');
})->name('dashboard-peck');

Route::middleware(['auth:sanctum', 'verified'])->get('/fly', function () {
    return view('fly');
})->name('dashboard-fly');

Route::middleware(['auth:sanctum', 'verified'])->get('/vote', function () {
    return view('vote');
})->name('dashboard-vote');

Route::middleware(['auth:sanctum', 'verified'])->get('/data/perchJSON/', [PerchJSON::class, 'perchJSON'])->name('data-perchJSON');

Route::middleware(['auth:sanctum', 'verified'])->get('/data/peckJSON/', [PeckJSON::class, 'peckJSON'])->name('data-peckJSON');