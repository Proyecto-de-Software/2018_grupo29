@extends('layouts.general')

@section('title', 'Reportes')

@section('content')

	<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>

	{!! $chart->container() !!}
	{!! $chart->script() !!}



@endsection