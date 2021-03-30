<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
  [
    'middleware' => 'api',
    'prefix'    =>'auth',
  ],function($router){

    Route::post('login','AuthController@login');
    Route::post('register','AuthController@register');
    Route::post('logout','AuthController@logout');
    Route::post('refresh','AuthController@refresh');
    Route::post('add','CalculatorController@addition');
    Route::post('subtract','CalculatorController@subtraction');
    Route::post('multiply','CalculatorController@multiplication');
    Route::post('divide','CalculatorController@division');
    Route::post('squareroot','CalculatorController@squareRoot');
    Route::post('save','CalculatorController@saveValue');
    Route::post('clear','CalculatorController@clearValue');
    Route::get('savedvalue','CalculatorController@savedValue');
  
  
});

