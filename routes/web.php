<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PuzzelController;
use Illuminate\Support\Facades\Route;
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

Route::get('/', [PuzzelController::class, 'index']);
Route::resource('/puzzels', PuzzelController::class)->middleware(['auth']);
Route::get('/allepuzzels/',  [PuzzelController::class, 'allePuzzels'])->name('allepuzzels');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::post('getJsonSearch', [GoogleController::class, 'getJsonSearch'])->middleware(['auth']);
require __DIR__ . '/auth.php';
Route::get('/search/',  [PuzzelController::class, 'search'])->name('search');
Route::get('/searchallepuzzels/',  [PuzzelController::class, 'searchallepuzzels'])->name('searchallepuzzels');
Route::post('/addimage', [PuzzelController::class, 'addimage'])->name('addimage');
Route::get('/editallepuzzels/{id}', [PuzzelController::class, 'editallepuzzels'])->name('editallepuzzels');
Route::put('/updateallepuzzels', [PuzzelController::class, 'updateallepuzzels'])->name('updateallepuzzels');
Route::post('/addfromallepuzzels', [PuzzelController::class, 'addFromAllepuzzels'])->name('addfromallepuzzels');

// Route::get('/search/{id}', [PuzzelController::class, 'search']);
