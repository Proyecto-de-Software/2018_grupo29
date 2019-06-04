@extends('layouts.general')

@section('title', 'Editar consulta')

@section('content')
	<h2 class="text-center"> Editar consulta de {{$patient->first_name}} {{$patient->last_name}} </h2>

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
	{!! Form::open(['route' => ['consultations.update', $consultation->id]]) !!}
	<div class="form-row">
		{{ method_field('PUT') }}
		{!! Form::hidden('patient_id', $patient->id) !!}
		{!! Form::hidden('id', $consultation->id) !!}

		<div class="form-group col-md-1"> </div>
		<div class="form-group col-md-5">
	    	{!! Form::label('diagnostic', 'Diagnóstico*') !!}	
			{!! Form::textarea('diagnostic', $consultation->diagnostic, ['class' => 'form-control', 'required', 'rows' => '5']) !!}
			<br>
			{!! Form::label('reason', 'Motivo*') !!}
			{!! Form::select('reason_id', ['1' => 'Receta Médica', '2' => 'Control por Guardia', '3' => 'Consulta', '4' => 'Intento de Suicidio', '5' => 'Interconsulta', '6' => 'Otro'], $consultation->reason_id, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('articulation','Articulacion') !!}
			{!! Form::textarea('articulation', $consultation->articulation, ['class' => 'form-control', 'rows' => '3']) !!}
			<br>
			{!! Form::label('treatment', 'Tratamiento farmacológico') !!}
			{!! Form::select('treatment_id', ['1' => 'Mañana', '2' => 'Tarde', '3' => 'Noche'], $consultation->treatment_id, ['class' => 'form-control', 'placeholder' => 'Elija un tratamiento']) !!}
	    </div>
			
		<div class="form-group col-md-5">

			{!! Form::label('date', 'Fecha de consulta*') !!}	
			{!! Form::date('date', $consultation->date, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('was_internment', '¿Hubo internación?*') !!}	
			{!! Form::select('was_internment', ['1' => 'Sí', '0' => 'No'], $consultation->was_internment, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('derivation', 'Derivación*') !!}
			<select id="derivation_id" class="form-control" name="derivation_id" style="width: 100%" required>
			  	@foreach ($institutions as $institution)
				    @if ($institution->id == $consultation->derivation_id)	
				    	<option value="{{ $institution->id }}" selected>
				    		{{ $institution->name }}
				    	</option>
				    @else
				    	<option value="{{ $institution->id }}">
				    		{{ $institution->name }}
				    	</option>
				    @endif
				@endforeach
			</select>
			<br>
			{!! Form::label('observations', 'Observaciones') !!}
	    	{!! Form::textarea('observations', $consultation->observations, ['class' => 'form-control', 'rows'=> '4']) !!}
	    	<br>
			{!! Form::label('accompaniment', 'Acompañamiento') !!}
			{!! Form::select('accompaniment_id', ['1' => 'Familiar cercano', '2' => 'Hermanos e hijos', '3' => 'Pareja', '4' => 'Referentes vinculares', '5' => 'Policía', '6' => 'SAME', '7' => 'Por sus propios medios'], $consultation->accompaniment_id, ['class' => 'form-control', 'placeholder' => 'Elija un acompañamiento']) !!}
	    </div>
	    <div class="form-group col-md-1"> </div>
	</div>
		<div class="row justify-content-center">
			{!! Form::submit('¡Listo!', ['class' => 'btn btn-outline-primary text-black btn my-2 my-sm-0 btn-lg']) !!}
		</div>
		{!! Form::close() !!}
	
		
@endsection