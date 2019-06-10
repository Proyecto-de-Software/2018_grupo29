@extends('layouts.general')

@section('title', 'Editar consulta')

@section('content')
	<h2 class="text-center"> Editar configuraciones</h2>
	<br>
	<br>
	<p class="text-center"> @include('flash::message') </p>
	<br>
	@if ($errors->any())
	    <div class="alert alert-danger">
	    	<p>El formulario no cumple con las siguientes condiciones: </p>
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif

	<p class="text-center"> Nota: los campos que tienen (*) son obligatorios </p>    
	{!! Form::open(['route' => ['configurations.update']]) !!}
	<div class="form-row">
		{{ method_field('PUT') }}

		<div class="form-group col-md-3"> </div>
		<div class="form-group col-md-6">
	    	{!! Form::label('title', 'Título*') !!}	
			{!! Form::text('title', $configuration['title']->value, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('pagination', 'Elementos por página*') !!}
			{!! Form::text('pagination', $configuration['pagination']->value , ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('maintenance', 'Sitio en mantenimiento*') !!}
			{!! Form::select('maintenance', ['0' => 'No', '1' => 'Si'] , $configuration['maintenance']->value , ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('email', 'Correo electrónico*') !!}
			{!! Form::text('email', $configuration['email']->value , ['class' => 'form-control', 'required']) !!}
			<br>
	    </div>
	    <div class="form-group col-md-3"> </div>
	</div>
		<div class="row justify-content-center">
			{!! Form::submit('¡Listo!', ['class' => 'btn btn-outline-primary text-black btn my-2 my-sm-0 btn-lg']) !!}
		</div>
		{!! Form::close() !!}
	
		
@endsection