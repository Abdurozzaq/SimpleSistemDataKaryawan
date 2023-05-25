<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Jabatan\Http\Controllers\JabatanController;

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

// Route::middleware('auth:api')->get('/jabatan', function (Request $request) {
//     return $request->user();
// });

Route::get('/jabatan', [JabatanController::class, 'index']);
Route::post('/jabatan/create', [JabatanController::class, 'create']);
Route::post('/jabatan/updatebyid', [JabatanController::class, 'updateById']);
Route::get('/jabatan/getbyid/{id}', [JabatanController::class, 'getById']);
Route::delete('/jabatan/deletebyid/{id}', [JabatanController::class, 'deleteById']);