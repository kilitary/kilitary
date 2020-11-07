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

Route::middleware(['cache.headers'])
    ->group(function() {
        Route::middleware('doNotCacheResponse')
            ->group(function() {
                Route::get('/cparea', 'PageController@cp');
                Route::get('/command/{command}', 'CommandController@command');
                Route::get('/admin/logs', 'LogController@index');

                Route::get('/relink', 'PageController@relink');
                Route::get('/comment/{ip}/delete-all-by-ip', 'PageController@deleteByIp');
                Route::get('/delete/{page_code}/{mode}', 'PageController@delete');
                Route::get('/edit/{code}', 'PageController@edit');
                Route::post('update/{code}', 'PageController@update');
                Route::post('/comment/add', 'PageController@writeComment');
                Route::get('/comment/{id}/delete', 'PageController@deleteComment');
                Route::get('/reset', 'PageController@reset');

                Route::get('/touch/{code}', 'PageController@touch');
            });

        Route::middleware('cacheResponse:34')
            ->group(function() {
                Route::get('/view/{page_code}', 'PageController@page');
                Route::get('/{file}.txt', 'TextController@identify');
                Route::get('/{file}.htm', 'TextController@identify');

                Route::any('/page/{page_code}', 'PageController@record');

                Route::get('/proxy', 'ProxyController@list');

                Route::get('/donate', 'PageController@donate');
            });

        Route::any('/home', 'HomeController@index');

        Route::get('/', 'PageController@index')->name('home');

        Route::post('/us/create', 'UrlController@create');
        Route::get('/us/{url}', 'UrlController@redirect');

        Route::fallback('PageController@index');
    });

