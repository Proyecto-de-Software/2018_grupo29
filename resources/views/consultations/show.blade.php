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
	                <p class="list-group-item list-group-item-action">Fecha de consulta</p>
	                <p class="list-group-item list-group-item-action">Articulación</p>
	                <p class="list-group-item list-group-item-action">Hubo internación?</p>
	                <p class="list-group-item list-group-item-action">Diagnóstico</p>
	                <p class="list-group-item list-group-item-action">Observaciones</p>
	                <p class="list-group-item list-group-item-action">Acompañamiento</p>
	                <p class="list-group-item list-group-item-action">Tratamiento</p>
	                <p class="list-group-item list-group-item-action">Motivo</p>
	                <p class="list-group-item list-group-item-action">Derivamiento</p>
	            </div>
	        </div>
	        <div class="col-6">
	            <div class="list-group d-flex flex-row flex-wrap">
	                <p class="list-group-item list-group-item-action">{{ $consultation->date }}</p>
	                <p class="list-group-item list-group-item-action">{{ $consultation->articulation }}</p>
	                <p class="list-group-item list-group-item-action">
		                @if ($consultation->was_internment)  
		                	Si
		                @else
		                	No
		                @endif
	                </p>
	                <p class="list-group-item list-group-item-action">{{ $consultation->diagnostic }}</p>
	                <p class="list-group-item list-group-item-action">{{ $consultation->observations }}</p>
	                <p class="list-group-item list-group-item-action">{{ $accompaniment }}</p>
	                <p class="list-group-item list-group-item-action">{{ $treatment }}</p>
	                <p class="list-group-item list-group-item-action">{{ $reason->name }}</p>
	                <p class="list-group-item list-group-item-action">{{ $institution->name }}</p>
	            </div>
	        </div>
	    </div>
    </div>
@endsection