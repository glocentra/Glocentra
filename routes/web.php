<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

//Route::get( '/h', 'AxxerionController@index');
Route::get('/home', [HomeController::class, 'index'])->name('index');


Route::get('/welcome', function(){
    return Inertia::render('Welcome', ['foo'=> 'bar']);
});




