@extends('layouts.general')

@section('title', 'Detalle de paciente')

@section('content')
	<h2 class="text-center"> Paciente {{ $patient->first_name }} {{ $patient->last_name }}</h2>
	<hr>
	&nbsp; <a href="{{ URL::previous() }}"> <button class="btn btn-primary"> Volver </button></a>
	<br>
	<div class="container">
	    <div class="row">
	        <div class="col-6">
	            <div class="list-group d-flex flex-row flex-wrap">
	                <p class="list-group-item list-group-item-action">Nombre</p>
	                <p class="list-group-item list-group-item-action">Apellido</p>
	                <p class="list-group-item list-group-item-action">Fecha de nacimiento</p>
	                <p class="list-group-item list-group-item-action">Domicilio actual</p>
	                <p class="list-group-item list-group-item-action">Género</p>
	                <p class="list-group-item list-group-item-action">¿Tiene el documento en su poder?</p>
	                <p class="list-group-item list-group-item-action">Número de documento</p>
	                <p class="list-group-item list-group-item-action">Número de teléfono</p>
	            </div>
	        </div>
	        <div class="col-6">
	            <div class="list-group d-flex flex-row flex-wrap">
	                <p class="list-group-item list-group-item-action">{{ $patient->first_name }}</p>
	                <p class="list-group-item list-group-item-action">{{ $patient->last_name }}</p>
	                <p class="list-group-item list-group-item-action">{{ $patient->birthdate }}</p>
	                <p class="list-group-item list-group-item-action">{{ $patient->home }}</p>
	                <p class="list-group-item list-group-item-action">{{ $patient->gender->name }}</p>
	                <p class="list-group-item list-group-item-action">
	                	@if ($patient->has_document == 1)
	                		Sí
	                	@else
	                		No
	                	@endif
	                </p>
	                <p class="list-group-item list-group-item-action">{{ $patient->dni_number }}</p>
	                <p class="list-group-item list-group-item-action"> &nbsp; {{ $patient->phone_number }}</p>
	            </div>
	        </div>
	    </div>
    </div>
@endsection