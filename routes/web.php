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

Route::get('reports', [
	'uses' => 'ReportController@index',
	'as' => 'reports.index'
]);

