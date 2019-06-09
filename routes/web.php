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

Auth::routes();

Route::get('/patient-ajax/{id}', 'PatientAjaxController@patientConsultations')->middleware('auth');
Route::get('/patient-ajax/partido/{id}', 'PatientAjaxController@getLocalidades')->middleware('auth');

Route::get('/', 'HomeController@index')->name('home');

Route::resource('consultations', 'ConsultationController')->middleware('auth');
Route::get('/consultations/create/{id}','ConsultationController@create')->middleware('auth');
Route::get('/consultations/edit/{id}',[
	'uses' => 'ConsultationController@edit',
	'as' => 'consultations.edit'
])->middleware('auth'); 
Route::get('/consultations/destroy/{id}', [
	'uses' => 'ConsultationController@destroy',
	'as' => 'consultations.destroy'
])->middleware('auth');
Route::get('/consultations/map/{id}', [
	'uses' => 'ConsultationController@map',
	'as' => 'consultations.map'
]);

#Módulo de Pacientes
Route::resource('patients', 'PatientController')->middleware('auth');
Route::get('patients/{id}/destroy', [
	'uses' => 'PatientController@destroy',
	'as' => 'patients.destroy'
])->middleware('auth');

# Módulo de Roles
Route::resource('roles', 'RoleController')->middleware('auth');
Route::group(['prefix' => 'roles','middleware' => 'auth'],function () {

	Route::get('{id}/destroy', [
		'uses' => 'RoleController@destroy',
		'as' => 'roles.destroy'
	]);

	Route::get('{id}/permissions/add/{permission_id}', [
		'uses' => 'RoleController@addPermission',
		'as' => 'roles.permissions.add'
	]);

	Route::get('{id}/permissions/remove/{permission_id}', [
		'uses' => 'RoleController@removePermission',
		'as' => 'roles.permissions.remove'
	]);

});

# Módulo de Usuarios
Route::resource('users', 'UserController')->except([
    'show',
])->middleware('auth');
Route::prefix('users')->middleware(['auth'])->group(function () {
    Route::get('{id}/block', [
	'uses' => 'UserController@block',
	'as' => 'users.block'
	]);
	Route::get('{id}/unblock', [
		'uses' => 'UserController@unblock',
		'as' => 'users.unblock'
	]);

	Route::get('{id}/destroy', [
		'uses' => 'UserController@destroy',
		'as' => 'users.destroy'
	]);

	Route::get('{id}/roles', [
		'uses' => 'UserController@roles',
		'as' => 'users.roles'
	])->middleware('auth');

	Route::get('{id}/roles/remove/{role_id}', [
		'uses' => 'UserController@removeRole',
		'as' => 'users.roles.remove'
	])->middleware('auth');

	Route::get('{id}/roles/add/{role_id}', [
		'uses' => 'UserController@addRole',
		'as' => 'users.roles.add'
	])->middleware('auth');
});

# Módulo de Reportes
Route::prefix('reports')->middleware(['auth'])->group(function () {

	Route::get('/all', [
		'uses' => 'ReportController@start',
		'as' => 'reports'
	]);
	Route::get('byReason', [
		'uses' => 'ReportController@byReason',
		'as' => 'reports.byReason'
	]);
	Route::get('byGender', [
		'uses' => 'ReportController@byGender',
		'as' => 'reports.byGender'
	]);
	Route::get('byLocation', [
		'uses' => 'ReportController@byLocation',
		'as' => 'reports.byLocation'
	]);

});

# Modulo de configuraciones
Route::get('configurations/edit', [
	'uses' => 'ConfigurationController@edit',
	'as' => 'configurations.edit'
])->middleware('auth');

Route::put('configurations/update',[
	'uses' => 'ConfigurationController@update',
	'as' => 'configurations.update'
])->middleware('auth');

# FRONTEND WITH VUE.JS

Route::get('buscador-instituciones','InstitutionController@buscador');