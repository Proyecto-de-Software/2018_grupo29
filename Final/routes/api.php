<?php

use Illuminate\Http\Request;

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


# Métodos para la API de Instituciones. 
Route::get('instituciones','InstitutionController@index');
Route::get('instituciones/{id}','InstitutionController@show');
Route::post('instituciones','InstitutionController@store');
Route::delete('instituciones/{id}','InstitutionController@destroy');
Route::put('instituciones/{id}','InstitutionController@update');
Route::get('instituciones/region-sanitaria/{region_sanitaria_id}', 'InstitutionController@getByHealthRegion');
