@extends('layouts.general')

@section('title', 'Listado de pacientes')

@section('content')
    <h2 class="text-center">Pacientes del Hospital</h2>
    <br>
    <hr>
    &nbsp; <a href="{{ route('patients.create') }}"> <button class="btn btn-success"> Nuevo paciente </button> </a>
    <br> 
    <p class="text-center"> @include('flash::message') </p>
    <br>
    <div class="row container-fluid">
    	<ul class="list-group" style="width: 100%">
	    	<li class="list-group-item row d-flex text-center">
	    		<div class="col-1 text-info">Nombre</div>
	    		<div class="col-2 text-info">Apellido</div>
	    		<div class="col-1 text-info">Género</div>
	    		<div class="col-2 text-info">Número de documento</div>
	    		<div class="col-1 text-info">Localidad</div>
	    		<div class="col-2 text-info">Fecha de nacimiento</div>
	    		<div class="col-1 text-info"></div>
	    		<div class="col-1 text-info"></div>
	    		<div class="col-1 text-info"></div>
	    	</li>
		    @foreach ($patients as $patient)
		    <li class="list-group-item row d-flex text-center">
		    	<div class="col-1"> {{ $patient->first_name }} </div>
		    	<div class="col-2"> {{ $patient->last_name }} </div>
		    	<div class="col-1"> {{ $patient->gender->name }} </div>
		    	<div class="col-2"> {{ $patient->dni_number }} </div>
		    	<div class="col-1"> Estático por ahora </div>
		    	<div class="col-2"> {{ $patient->birthdate }}</div>
		    	<div class="col-1"> <button class="btn btn-success">Ver</button> </div>
		    	<div class="col-1"> <button class="btn btn-warning">Editar</button> </div>
		    	<div class="col-1">
		    		{!! Form::open([ 'method'  => 'DELETE', 'route' => [ 'patients.destroy', $patient ] ]) !!}
		    		{!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
            		{!! Form::close() !!}
		    	</div>
		    </li>
			@endforeach
		</ul>
	</div>
	<br>
	<div class="row container-fluid justify-content-center align-items-center"> {{ $patients->links() }} </div>
@endsection

