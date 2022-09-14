<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
    return view('welcome');
});

Route::post('/generate', [\App\Http\Controllers\GenerateController::class, 'generate'])->name('generate');


Route::get('/download-example', function(){
    try {
        return Storage::download('students.xlsx');
    } catch (Exception $e) {
        abort(404);
    }
    }
);

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);
