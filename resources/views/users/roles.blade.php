@extends('layouts.general')

@section('title', 'Roles de usuario')

@section('content')
	
	<h2 class="text-center"> Roles de {{ $user->first_name }} {{ $user->last_name}} </h2>

	@foreach ($roles as $rol)
		<p> {{ $rol->name }} </p>
	@endforeach

@endsection