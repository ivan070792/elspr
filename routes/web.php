<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\{DocumentController, GenerateController};

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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Auth::routes([
    'register' => false,
]);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/documents/elspr/form', [DocumentController::class, 'elsprForm'])->name('documents.elspr.form');
    Route::get('/documents/elspr/download-example', [DocumentController::class, 'downloadExample'])->name('documents.elspr.example');
    Route::post('/documents/elspr/generate', [GenerateController::class, 'generate' ])->name('documents.elspr.generate');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::get('/test', [DocumentController::class, 'testFetch']);


