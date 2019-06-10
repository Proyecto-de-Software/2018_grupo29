@extends('layouts.general')

@section('title', 'Crear nueva consulta')

@section('content')
	<h2 class="text-center"> Nueva consulta para {{ $patient->first_name }} {{ $patient->last_name }}</h2>

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

	{!! Form::hidden('patient_id', $patient->id) !!}

	<div class="form-row">
		
		<div class="form-group col-md-1"> </div>
		<div class="form-group col-md-5">
	    	{!! Form::label('diagnostic', 'Diagnóstico*') !!}	
			{!! Form::textarea('diagnostic', null, ['class' => 'form-control', 'required', 'rows' => '5']) !!}
			<br>
			{!! Form::label('reason', 'Motivo*') !!}
			{!! Form::select('reason_id', ['1' => 'Receta Médica', '2' => 'Control por Guardia', '3' => 'Consulta', '4' => 'Intento de Suicidio', '5' => 'Interconsulta', '6' => 'Otro'], null, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('articulation','Articulacion') !!}
			{!! Form::textarea('articulation', null, ['class' => 'form-control', 'rows' => '3']) !!}
			<br>
			{!! Form::label('treatment', 'Tratamiento farmacológico') !!}
			{!! Form::select('treatment_id', ['1' => 'Mañana', '2' => 'Tarde', '3' => 'Noche'], null, ['class' => 'form-control', 'placeholder' => 'Elija un tratamiento']) !!}
	    </div>
			
		<div class="form-group col-md-5">

			{!! Form::label('date', 'Fecha de consulta*') !!}	
			{!! Form::date('date', \Carbon\Carbon::create(2019, 05, 20), ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('was_internment', '¿Hubo internación?*') !!}	
			{!! Form::select('was_internment', ['1' => 'Sí', '0' => 'No'], null, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('derivation', 'Derivación*') !!}
			<select id="derivation_id" class="form-control" name="derivation_id" style="width: 100%" required>
			  	@foreach ($institutions as $institution)
			    	<option value="{{ $institution->id }}">
			    		{{ $institution->name }}
			    	</option>
				@endforeach
			</select>
			<br>
			{!! Form::label('observations', 'Observaciones') !!}
	    	{!! Form::textarea('observations', null, ['class' => 'form-control', 'rows'=> '4']) !!}
	    	<br>
			{!! Form::label('accompaniment', 'Acompañamiento') !!}
			{!! Form::select('accompaniment_id', ['1' => 'Familiar cercano', '2' => 'Hermanos e hijos', '3' => 'Pareja', '4' => 'Referentes vinculares', '5' => 'Policía', '6' => 'SAME', '7' => 'Por sus propios medios'], null, ['class' => 'form-control', 'placeholder' => 'Elija un acompañamiento']) !!}
	    </div>
	    <div class="form-group col-md-1"> </div>
	</div>
		<div class="row justify-content-center">
			{!! Form::submit('¡Listo!', ['class' => 'btn btn-outline-primary text-black btn my-2 my-sm-0 btn-lg']) !!}
		</div>
		{!! Form::close() !!}
	
		
@endsection