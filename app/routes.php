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

Route::get('/', function()
{
    Session::flush();
    return View::make('index');
});

Route::get('form', function() {

    return View::make('form');
});

Route::post('confirm', function() {

    //$hobby_view = implode(" ", Session::getOldInput('hobby'));
    Input::flash();
    //Session::flashInput($hobby_view);
    return View::make('confirm');
    Session::reflash();
});

Route::post('done', function() {

    return View::make('done');
});
