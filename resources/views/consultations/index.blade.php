@extends('layouts.general')

@section('title', 'Consultas')

@section('content')
    <h2 class="text-center">Pacientes del Hospital</h2>
    <br>
    <hr>
    <div class="container">
  		<div class="row justify-content-center">
  			<div class="col-4">
			    <select id="patients" class="select-single" name="patients" style="width: 100%">
				  	@foreach ($patients as $patient)
				    	<option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
	&nbsp;&nbsp;&nbsp;
	<div class="container">
		<div class="row justify-content-center">
			<button id="toggle" class="btn btn-primary" onclick="changeButton()">Mostrar consultas</button>
		</div>
	</div>
	&nbsp;&nbsp;&nbsp;
	<div class="container">
		<div class="row justify-content-center">
			<div id='consultations' style="display: none;">
				<p>Aca irian las consultas</p>					
			</div>
		</div>
	</div>
	@permission('consultations_new')
	&nbsp;&nbsp;&nbsp;
	<div class="container">
		<div class="row justify-content-center">
			<a class="btn btn-success" href="{{ route('consultations.create') }}">Crear nueva consulta</a>
		</div>
	</div>
	@endpermission
	<script type="text/javascript" src="{{ asset('js/ajaxConsultasPacientes.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/consultations.js') }}"></script>
@endsection

