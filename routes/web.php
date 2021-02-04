<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerchJSON;
use App\Http\Controllers\FlyJSON;
use App\Http\Controllers\FlyJSONPublic;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [HomeController::class, 'index'])->name('welcome')->middleware('guest');

Route::middleware(['auth:sanctum', 'verified'])->get('/perch', function () {
    $this_user_id = Auth::id();
    $categories = DB::table('categories')->get();
    $user_data = DB::table('users')->where('id', '=', $this_user_id)->get()->first();
    // dd($user_data);
    return view('perch')
                        ->with('categories', $categories)
                        ->with('user_data', $user_data);
})->name('dashboard-perch');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $this_user_id = Auth::id();
    $categories = DB::table('categories')->get();
    $user_data = DB::table('users')->where('id', '=', $this_user_id)->get()->first();
    return view('perch')
    ->with('categories', $categories)
    ->with('user_data', $user_data);;
})->name('dashboard-perch');

Route::middleware(['auth:sanctum', 'verified'])->get('/fly', function () {
    return view('fly');
})->name('dashboard-fly');

Route::middleware(['auth:sanctum', 'verified'])->get('/nest', function () {
    $this_user_id = Auth::id();
    $categories = DB::table('categories')->get();
    $user_data = DB::table('users')->where('id', '=', $this_user_id)->get()->first();
    return view('perch')
    ->with('categories', $categories)
    ->with('user_data', $user_data);;
})->name('dashboard-perch');

Route::middleware(['auth:sanctum', 'verified'])->get('/data/perchJSON/', [PerchJSON::class, 'perchJSON'])->name('data-perchJSON');

Route::middleware(['auth:sanctum', 'verified'])->get('/data/flyJSON/', [FlyJSON::class, 'flyJSON'])->name('data-flyJSON');

Route::get('/data/flyJSONPublic/', [FlyJSONPublic::class, 'flyJSONPublic'])->name('data-flyJSONPublic');