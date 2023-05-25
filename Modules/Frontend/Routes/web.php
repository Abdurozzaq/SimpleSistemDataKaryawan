<?php
use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controllers\FrontendController;

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

Route::get('/', 'FrontendController@index');
Route::get('/pegawai', 'FrontendController@pegawai');
Route::get('/jabatan', 'FrontendController@jabatan');
Route::get('/kontrak', 'FrontendController@kontrak');
