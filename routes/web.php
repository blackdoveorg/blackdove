<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ReportJSON;
use App\Http\Controllers\BrowseJSON;
use App\Http\Controllers\BrowseJSONPublic;
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

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::middleware(['auth:sanctum', 'verified'])->get('/report', function () {
    $this_user_id = Auth::id();
    $categories = DB::table('categories')->get();
    $user_data = DB::table('users')->where('id', '=', $this_user_id)->get()->first();
    // dd($user_data);
    return view('report')
                        ->with('categories', $categories)
                        ->with('user_data', $user_data);
})->name('dashboard-report');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $this_user_id = Auth::id();
    $categories = DB::table('categories')->get();
    $user_data = DB::table('users')->where('id', '=', $this_user_id)->get()->first();
    return view('report')
    ->with('categories', $categories)
    ->with('user_data', $user_data);;
})->name('dashboard-report');

Route::middleware(['auth:sanctum', 'verified'])->get('/browse', function () {
    return view('browse');
})->name('dashboard-browse');

Route::middleware(['auth:sanctum', 'verified'])->get('/report', function () {
    $this_user_id = Auth::id();
    $categories = DB::table('categories')->get();
    $user_data = DB::table('users')->where('id', '=', $this_user_id)->get()->first();
    return view('report')
    ->with('categories', $categories)
    ->with('user_data', $user_data);;
})->name('dashboard-report');

Route::middleware(['auth:sanctum', 'verified'])->get('/data/reportJSON/', [ReportJSON::class, 'reportJSON'])->name('data-reportJSON');

Route::middleware(['auth:sanctum', 'verified'])->get('/data/browseJSON/', [BrowseJSON::class, 'browseJSON'])->name('data-browseJSON');

Route::get('/data/browseJSONPublic/', [BrowseJSONPublic::class, 'browseJSONPublic'])->name('data-browseJSONPublic');