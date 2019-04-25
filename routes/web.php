<?php

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

Route::resource('patients', 'PatientController')->middleware('auth');

# La siguiente ruta es para no tener que hacer un formulario para tener que eliminar
# un paciente. Así, se puede hacer con un solo tag 'a'.
Route::get('patients/{id}/destroy', [
	'uses' => 'PatientController@destroy',
	'as' => 'patients.destroy'
])->middleware('auth');


Route::resource('consultations', 'ConsultationController');

Route::resource('users', 'UserController')->middleware('auth');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
