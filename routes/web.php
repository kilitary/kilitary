<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

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

Route::get('/', 'PageController@index');

Route::get('/view/{page_code}', 'PageController@page');
Route::any('/page/{page_code}', 'PageController@record');
Route::get('/delete/{page_code}', 'PageController@delete');

Route::get('/command/{command}', 'CommandController@command');

Route::get('/{file}.txt', 'TextController@identify');

Route::post('/us/create', 'UrlController@create');
Route::get('/us/{url}', 'UrlController@redirect');
Route::any('/home', 'HomeController@index');

Route::fallback('PageController@fallback');
