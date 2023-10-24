<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PuzzelController;
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

Route::resource('products', ProductController::class);
Route::resource('puzzels', PuzzelController::class);

// // returns the home page with all posts
// Route::get('/', PuzzelController::class . '@index')->name('posts.index');
// // returns the form for adding a post
// Route::get('/puzzels/create', PuzzelController::class . '@create')->name('posts.create');
// // adds a post to the database
// Route::post('/puzzels', PuzzelController::class . '@store')->name('posts.store');
// // returns a page that shows a full post
// Route::get('/puzzels/{puzzel}', PuzzelController::class . '@show')->name('posts.show');
// // returns the form for editing a post
// Route::get('/puzzels/{puzzel}/edit', PuzzelController::class . '@edit')->name('posts.edit');
// // updates a post
// Route::put('/puzzels/{puzzel}', PuzzelController::class . '@update')->name('posts.update');
// // deletes a post
// Route::delete('/puzzels/{puzzel}', PuzzelController::class . '@destroy')->name('posts.destroy');