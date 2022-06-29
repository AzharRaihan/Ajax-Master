<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\AjaxCrudController;
use App\Http\Controllers\DependingDropdownController;

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



// Country 
Route::get('/country-create', [CountryController::class, 'countryCreate'])->name('country.create');
Route::get('/country-index', [CountryController::class, 'countryIndex']);
Route::post('/country-store', [CountryController::class, 'countryStore']);
Route::get('/country-edit/{id}', [CountryController::class, 'countryEdit']);
Route::put('/country-update/{id}', [CountryController::class, 'countryUpdate']);
Route::delete('/country-delete/{id}', [CountryController::class, 'countryDelete']);


// State
Route::get('/state-create', [StateController::class, 'stateCreate'])->name('state.create');
Route::get('/state-index', [StateController::class, 'stateIndex']);
Route::get('/country-get', [StateController::class, 'countryGet']);
Route::post('/state-store', [StateController::class, 'stateStore']);
Route::get('/state-edit/{id}', [StateController::class, 'stateEdit']);
Route::put('/state-update/{id}', [StateController::class, 'stateUpdate']);
Route::delete('/state-delete/{id}', [StateController::class, 'stateDelete']);



// Depending Dropdown 
Route::get('depending-dropdown', [DependingDropdownController::class, 'dependingDropdown']);
Route::get('d-country', [DependingDropdownController::class, 'dCountry']);
Route::get('d-state/{id}', [DependingDropdownController::class, 'dState']);