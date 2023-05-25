<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Kontrak\Http\Controllers\KontrakController;

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

// Route::middleware('auth:api')->get('/kontrak', function (Request $request) {
//     return $request->user();
// });

Route::get('/kontrak', [KontrakController::class, 'index']);
Route::post('/kontrak/create', [KontrakController::class, 'create']);
Route::get('/kontrak/getbyid/{id}', [KontrakController::class, 'getById']);
Route::delete('/kontrak/deletebyid/{id}', [KontrakController::class, 'deleteById']);