@extends('layouts.general')

@section('title', 'Consultas')

@section('content')
    <h2 class="text-center">Pacientes del Hospital</h2>
    <br>
    <hr>
    <br> 
    <p class="text-center"> @include('flash::message') </p>
    <br>
    <div class="container">
  		<div class="row justify-content-center">
  			<div class="col-4">
			    <select id="patients" class="select-single" name="patients" style="width: 100%" onchange="modifyText()">
				  	<option style="display:none"></option>
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
			<button id="toggle" class="btn btn-primary" style="display: none;" onclick="changeButton()">Mostrar consultas</button>
		</div>
	</div>
	&nbsp;&nbsp;&nbsp;
	<div class="container">
		<div id='consultations' style="display: none;">
			<table id="table_id" class="display" style="width:100%">
				   
			</table>
			<button class="btn-primary">Ver mapa de consultas</button>
		</div>
	</div>
	@permission('consultations_new')
	&nbsp;&nbsp;
	<div class="container">
		<div class="row justify-content-center">
			<a id="newConsultation" class="btn btn-success" style="display: none;" href="{{ url('/consultations/create/') }}"></a>
		</div>
	</div>
	@endpermission
	<script type="text/javascript" src="{{ asset('js/ajaxConsultasPacientes.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/consultations.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/dataTables.js') }}"></script>
@endsection

