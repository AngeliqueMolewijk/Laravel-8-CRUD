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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::resource('/puzzels', PuzzelController::class)->middleware(['auth']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::post('getJsonSearch', [GoogleController::class, 'getJsonSearch'])->middleware(['auth']);
require __DIR__ . '/auth.php';
