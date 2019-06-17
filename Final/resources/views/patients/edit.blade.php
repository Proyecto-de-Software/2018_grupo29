@extends('layouts.general')

@section('title', 'Editar paciente')

@section('content')
	<h2 class="text-center"> Editar datos de {{$patient->first_name}} {{$patient->last_name}} </h2>

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
	{!! Form::open(['route' => ['patients.update', $patient->id]]) !!}
	<div class="form-row">
		{{ method_field('PUT') }}
		{!! Form::hidden('id', $patient->id) !!}
		<div class="form-group col-md-1"> </div>
		<div class="form-group col-md-5">
	    	{!! Form::label('first_name', 'Nombre*') !!}
	    	{!! Form::text('first_name', $patient->first_name, ['class' => 'form-control', 'required']) !!}
	    	<br>
	    	{!! Form::label('last_name', 'Apellido*') !!}	
			{!! Form::text('last_name', $patient->last_name, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('birthdate', 'Fecha de nacimiento*') !!}	
			{!! Form::date('birthdate', $patient->birthdate, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('partido', 'Partido') !!}
			<select id="partidos" class="form-control">
				@foreach ($partidos as $partido)
					@if ($patient->location_id == $partido->id)
					<option value="{{ $partido->id }}" selected=""> {{ $partido->nombre }}</option>
					@else
					<option value="{{ $partido->id }}"> {{ $partido->nombre }}</option>
					@endif
				@endforeach
			</select>
			<br>
			{!! Form::label('localidad', 'Localidad') !!}
			<select name="location_id" id="localidades" class="form-control">
				<!-- Se cargan mediante AJAX -->
			</select>
			<br>
			{!! Form::label('region_sanitaria', 'Región Sanitaria') !!}
			<select name="health_region_id" class="form-control">
				@foreach ($regiones_sanitarias as $region_sanitaria)
					@if ($patient->health_region_id == $region_sanitaria->id)
					<option value="{{ $region_sanitaria->id }}" selected=""> {{ $region_sanitaria->nombre }}</option>
					@else
					<option value="{{ $region_sanitaria->id }}" > {{ $region_sanitaria->nombre }}</option>
					@endif
				@endforeach
			</select>
			<br>
			{!! Form::label('domicilio', 'Domicilio actual*') !!}	
			{!! Form::text('home', $patient->home, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('place_of_birth', 'Lugar de nacimiento') !!}	
			{!! Form::text('place_of_birth', $patient->place_of_birth, ['class' => 'form-control']) !!}
			<br>
	    </div>
			
		<div class="form-group col-md-5">

			{!! Form::label('gender', 'Género*') !!}	
			{!! Form::select('gender_id', ['1' => 'Masculino', '2' => 'Femenino', '3' => 'Otro'], $patient->gender->id, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('tiene_documento', '¿Tiene el documento en su poder?*') !!}	
			{!! Form::select('has_document', ['1' => 'Sí', '0' => 'No'], $patient->has_document, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('tipo_documento', 'Tipo de Documento') !!}
			<select name="documentation_type_id" class="form-control">
				@foreach ($tipos_documentos as $tipo)
					@if ($patient->documentation_type_id == $tipo->id)
					<option value="{{ $tipo->id }}" selected=""> {{ $tipo->nombre }}</option>
					@else
					<option value="{{ $tipo->id }}"> {{ $tipo->nombre }}</option>
					@endif
				@endforeach
			</select>
			<br>
			{!! Form::label('dni_number', 'Número de documento*') !!}
	    	{!! Form::text('dni_number', $patient->dni_number, ['class' => 'form-control', 'required']) !!}
	    	<br>
	    	{!! Form::label('obra_social', 'Obra social') !!}
			<select name="social_work_id" class="form-control">
				@foreach ($obras_sociales as $obra_social)
					@if ($patient->social_work_id == $obra_social->id)
					<option value="{{ $obra_social->id }}" selected="">  {{ $obra_social->nombre }}</option>
					@else
					<option value="{{ $obra_social->id }}">  {{ $obra_social->nombre }}</option>
					@endif
				@endforeach
			</select>
	    	<br>
	    	{!! Form::label('phone_number', 'Número de teléfono') !!}
	    	{!! Form::text('phone_number', $patient->phone_number, ['class' => 'form-control']) !!}
	    	<br>
	    	{!! Form::label('medical_history_number', 'Número de historia clínica') !!}
	    	{!! Form::text('medical_history_number', $patient->medical_history_number, ['class' => 'form-control']) !!}
	    	<br>
	    	{!! Form::label('folder_number', 'Número de carpeta') !!}
	    	{!! Form::text('folder_number', $patient->folder_number, ['class' => 'form-control']) !!}
	    	<br>
	    </div>
	    <div class="form-group col-md-1"> </div>
	</div>
		<div class="row justify-content-center">
			{!! Form::submit('Actualizar', ['class' => 'btn btn-outline-primary text-black btn my-2 my-sm-0 btn-lg']) !!}
		</div>
		{!! Form::close() !!}
	
<script type="text/javascript" src="{{ asset('js/ajaxPatientCreate.js') }}"></script>
	
@endsection