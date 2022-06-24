<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxCrudController;

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

// Ajax Crud
Route::get('/crude-create', [AjaxCrudController::class, 'crudCreate'])->name('crud.create');
Route::get('/crude-index', [AjaxCrudController::class, 'crudIndex']);
Route::post('/crude-store', [AjaxCrudController::class, 'crudStore']);
Route::get('/crude-edit/{id}', [AjaxCrudController::class, 'crudEdit']);
Route::put('/crude-update/{id}', [AjaxCrudController::class, 'crudUpdate']);
Route::delete('/crude-delete/{id}', [AjaxCrudController::class, 'crudDelete']);
