@extends('layouts.general')

@section('title', 'Crear nuevo paciente')

@section('content')
	<h2 class="text-center"> Nuevo paciente </h2>

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
	{!! Form::open(['route' => 'patients.store']) !!}
	<div class="form-row">
		
		<div class="form-group col-md-1"> </div>
		<div class="form-group col-md-5">
	    	{!! Form::label('first_name', 'Nombre*') !!}
	    	{!! Form::text('first_name', null, ['class' => 'form-control', 'required']) !!}
	    	<br>
	    	{!! Form::label('last_name', 'Apellido*') !!}	
			{!! Form::text('last_name', null, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('birthdate', 'Fecha de nacimiento*') !!}	
			{!! Form::date('birthdate', \Carbon\Carbon::create(1990, 12, 31), ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('domicilio', 'Domicilio actual*') !!}	
			{!! Form::text('home', null, ['class' => 'form-control', 'required']) !!}
			<br>
	    </div>
			
		<div class="form-group col-md-5">

			{!! Form::label('gender', 'Género*') !!}	
			{!! Form::select('gender_id', ['1' => 'Masculino', '2' => 'Femenino', '3' => 'Otro'], null, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('tiene_documento', '¿Tiene el documento en su poder?*') !!}	
			{!! Form::select('has_document', ['1' => 'Sí', '0' => 'No'], null, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('dni_number', 'Número de documento*') !!}
	    	{!! Form::text('dni_number', null, ['class' => 'form-control', 'required']) !!}
	    	<br>
	    	{!! Form::label('phone_number', 'Número de teléfono') !!}
	    	{!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
	    	<br>
	    </div>
	    <div class="form-group col-md-1"> </div>
	</div>
		<div class="row justify-content-center">
			{!! Form::submit('¡Listo!', ['class' => 'btn btn-outline-primary text-black btn my-2 my-sm-0 btn-lg']) !!}
		</div>
		{!! Form::close() !!}
	
		
@endsection