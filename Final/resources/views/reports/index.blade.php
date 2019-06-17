 <script src="https://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous"> </script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="{{ asset('js/logicaGraficos.js')}}"></script>

 <body onload="first()"> 

@extends('layouts.general')

@section('title', 'Reportes')

@section('content')

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.debug.js"></script>



	&nbsp;
	<button id="byReason" class="btn btn-primary">Por motivo</button>
	<button id="byGender" class="btn btn-primary">Por género</button>
	<button id="byLocation" class="btn btn-primary">Por localidad</button>

	<br> <br>

	<div id="grafico" style="width:100%; height:400px;"></div>
	
	<br> <br>
	&nbsp;
	<button class="btn btn-primary" onclick="toPdf()"> Exportar listado a PDF </button>
	<h2 id='titulo' class="text-center">Listado de consultas</h2>
	<div id="listado"></div>


	<div id="chartContainer"></div>
@endsection
