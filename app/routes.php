<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'FormController@getIndex');

Route::get('form', 'FormController@getForm');

Route::post('confirm', ['before'=>'csrf', 'uses'=>'FormController@postConfirm']);

Route::post('done', 'FormController@postDone');

//RESTfulにするなら下記でも良いらしく
//Route::controller('/', 'FormController');
