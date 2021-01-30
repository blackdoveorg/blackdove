<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerchJSON;
use App\Http\Controllers\FlyJSON;
use App\Http\Controllers\FlyJSONPublic;
use Illuminate\Support\Facades\DB;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/nest', function () {
        return view('dashboard');
    })->name('nest');

Route::middleware(['auth:sanctum', 'verified'])->get('/perch', function () {
    $categories = DB::table('categories')->get();
    return view('perch')->with('categories', $categories);
})->name('dashboard-perch');

Route::middleware(['auth:sanctum', 'verified'])->get('/fly', function () {
    return view('fly');
})->name('dashboard-fly');

Route::middleware(['auth:sanctum', 'verified'])->get('/data/perchJSON/', [PerchJSON::class, 'perchJSON'])->name('data-perchJSON');

Route::middleware(['auth:sanctum', 'verified'])->get('/data/flyJSON/', [FlyJSON::class, 'flyJSON'])->name('data-flyJSON');

Route::get('/data/flyJSONPublic/', [FlyJSONPublic::class, 'flyJSONPublic'])->name('data-flyJSONPublic');