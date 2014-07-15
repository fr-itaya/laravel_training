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

    Input::flash();
    $hobby_view = implode(' ', Session::getOldInput('hobby'));
    return View::make('confirm')->with('hobby_view', $hobby_view);
});

Route::post('done', function() {

    Session::reflash();
    return View::make('done');
});
