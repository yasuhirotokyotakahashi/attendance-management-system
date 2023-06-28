<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\TimeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index']);
});


Route::get('/time', [TimeController::class, 'index']);

Route::get('/performance', [TimeController::class, 'performance']);

Route::get('/timein', [TimeController::class, 'timein']);
Route::post('/timein', [TimeController::class, 'timein']);
Route::get('/timeout', [TimeController::class, 'timeout']);
Route::post('/timeout', [TimeController::class, 'timeout']);

Route::get('/breakin', [RestController::class, 'breakin']);
Route::post('/breakin', [RestController::class, 'breakin']);
Route::post('/breakout', [RestController::class, 'breakout']);
