<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\{DocumentController, GenerateController};
use App\Http\Controllers\Documents\EduSertificateController;

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
    return view('auth.login');
})->middleware('guest');

Auth::routes(['register' => false, 'reset' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);

    Route::group(['prefix' =>'dashboard'], function () {
        Route::group(['prefix' =>'edu-sertificate'], function () {
            Route::get('index', [EduSertificateController::class, 'indexForm'])
                ->name('documents.edu_sertificate.index');
            Route::get('download-example', [EduSertificateController::class, 'downloadExampleXlsx'])
                ->name('documents.edu_sertificate.download_example');
            Route::post('index-form-request', [EduSertificateController::class, 'indexFormRequest'])
                ->name('documents.edu_sertificate.index_form_request');
        });
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});


