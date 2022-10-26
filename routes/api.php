<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);//->middleware(['auth']);//->name('dashboard');
Route::get('/display/{id}', [DashboardController::class, 'show']);

Route::get('file-download/{id}', [FilesController::class, 'Downloadfile']);
Route::post('/file-store', [FilesController::class, 'fileStore'])->name('file.store');
Route::get('file-delete/{id}',[FilesController::class, 'fileDestroy']);
Route::post('file-update/{id}', [FilesController::class, 'fileUpdate']);