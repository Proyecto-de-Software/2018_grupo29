@extends('layouts.general')

@section('title', 'Crear nueva consulta')

@section('content')
	<h2 class="text-center"> Nueva Consulta </h2>

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
	{!! Form::open(['route' => 'consultations.store']) !!}
	<div class="form-row">
		
		<div class="form-group col-md-1"> </div>
		<div class="form-group col-md-5">
	    	{!! Form::label('last_name', 'Apellido*') !!}	
			{!! Form::text('last_name', null, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('date', 'Fecha de consulta*') !!}	
			{!! Form::date('date', \Carbon\Carbon::create(2019, 05, 20), ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('motive', 'Motivo*') !!}	
			{!! Form::select('motive_id', ['1' => 'Receta Médica', '2' => 'Control por Guardia', '3' => 'Consulta', '4' => 'Intento de Suicidio', '5' => 'Interconsulta', '6' => 'Otros'], null, ['class' => 'form-control', 'required']) !!}
			<br>
			<select id="patients" class="select-single" name="patients" style="width: 100%">
			  	@foreach ($patients as $patient)
			    	<option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
				@endforeach
			</select>
	    </div>
			
		<div class="form-group col-md-5">

			{!! Form::label('gender', 'Género*') !!}	
			{!! Form::select('gender_id', ['1' => 'Masculino', '2' => 'Femenino', '3' => 'Otro'], null, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('was_internment', '¿Hubo internación?*') !!}	
			{!! Form::select('was_internment', ['1' => 'Sí', '0' => 'No'], null, ['class' => 'form-control', 'required']) !!}
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