@extends('layouts.general')

@section('title', 'Consultas')

<script>
	var app_pages='{{ $pagination }}';
</script>

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
	<script>
		var show=false;
		var update=false;
		var destroy=false;
	</script>
	@permission('consultations_show')
		<script>
			var show=true;
		</script>
	@endpermission
	@permission('consultations_update')
		<script>
			var update=true;
		</script>
	@endpermission
	@permission('consultations_destroy')
		<script>
			var destroy=true;
		</script>
	@endpermission

	<div class="container">
		<div id='consultations' style="display: none;">
			<table id="table_id" class="display" style="width:100%">
				   
			</table>
			<a id="map_button" href="#" class="btn-primary">Ver mapa de consultas</a>
		</div>
	</div>
	@permission('consultations_new')
	&nbsp;&nbsp;
	<div class="container">
		<div class="row justify-content-center">
			<a id="newConsultation" class="btn btn-success" style="display: none;" href="#"></a>
		</div>
	</div>
	@endpermission
	<script type="text/javascript" src="{{ asset('js/ajaxConsultasPacientes.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/consultations.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/DataTables/datatables.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/dataTables.js') }}"></script>
@endsection

