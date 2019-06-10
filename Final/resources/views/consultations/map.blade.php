@extends('layouts.general')

@section('title', 'Mapa de consultas')
<script type="text/javascript" src="{{ asset('plugins/leaflet/leaflet.js') }}"></script>
<link href="{{ asset('plugins/leaflet/leaflet.css') }}" rel="stylesheet">

@section('content')
<h2 class="text-center"> Mapa de consultas de {{ $patient->first_name }} {{ $patient->last_name }}</h2>
<br>
<br>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-2">
			@foreach ($institutions as $institution)
    			<li>{{ $institution->name }}</li>
			@endforeach
		</div>
		<div class="col-10" id="mapDiv" style="height: 400px"></div>
	</div>
</div>

<script type="text/javascript" src="{{ asset('js/mapa.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/leaflet/leaflet.js') }}"></script>
@foreach ($institutions as $institution)
	<script>addMarker({{ $institution->x_coordinate }},{{ $institution->y_coordinate }})</script>
@endforeach
@endsection