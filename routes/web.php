<?php

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


Route::get('/', function () {
    return view('auth.login');
})->name('index');

Route::get('/view-register', 'Auth\RegisterController@view')->name('view-register');

Route::post('/register', 'Auth\RegisterController@create')->name('register');

Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


Route::group(['middleware' => 'checkauthuser'], function () {
    Route::prefix('admin')
         ->name('admin.')
        ->group(function () {
                Route::get('/dashboard', 'HomeController@index')->name('dashboard');
                Route::get('/form', 'FormController@index')->name('form');

                Route::get('/find-parameter/{type}/{parameter}', 'FormController@getIdContrato')->name('find-parameter');

                Route::get('/find/{id}', 'FormController@findContrato')->name('find');
                Route::post('/create', 'FormController@createContrato')->name('create');
                Route::post('/update', 'FormController@updateContrato')->name('update');
                Route::get('/destroy/{id}', 'FormController@destroyContrato')->name('destroy');

        });

    Route::prefix('unidade')
         ->name('unidade.')
         ->group(function () {
                Route::post('/create', 'FormController@createUnidade')->name('create');
                Route::post('/update', 'FormController@updateUnidade')->name('update');
                Route::get('/destroy/{id}', 'FormController@destroyUnidade')->name('destroy');
        });

    Route::prefix('contrato-usuario')
         ->name('contrato-usuario.')
         ->group(function () {
                Route::post('/create', 'FormController@createUserContrato')->name('create');
                Route::get('/destroy/{id}/{idContrato}', 'FormController@destroyUserContrato')->name('destroy');

                Route::get('/find-parameter/{type}/{parameter}', 'FormController@getIdUsuario')->name('find-parameter');
         });



    Route::prefix('/dev')
         ->group(function() {
             Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
         });


});

