<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoCollectController;

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
    return view('Ajax-Crud.index');
});

Route::get('index', [InfoCollectController::class, 'index']);
Route::post('store', [InfoCollectController::class, 'store']);
Route::get('edit/{id}', [InfoCollectController::class, 'edit']);
Route::put('update/{id}', [InfoCollectController::class, 'update']);
Route::delete('delete/{id}', [InfoCollectController::class, 'delete']);
