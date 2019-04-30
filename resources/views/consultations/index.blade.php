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
	<script type="text/javascript" src="{{ asset('js/ajaxConsultasPacientes.js') }}"></script>
@endsection

