@extends('layouts.general')

@section('title', 'Listado de pacientes')

@section('content')
    <h2 class="text-center">Pacientes del Hospital</h2>
    <br>
    <hr>
    &nbsp; 
    @permission('patients_new')
    <a href="{{ route('patients.create') }}"> <button class="btn btn-success"> Nuevo paciente </button> </a>
    @endpermission
    <br><br>
    {!! Form::open(['route' => 'patients.index', 'method' => 'GET', 'class' => 'navbar-form pull-right']) !!}
    	<div class="form-group row">
    		<div class="col-1"> </div>
    		<div class="col-3">
    			{!! Form::text('first_name', Request::get('first_name'), ['class' => 'form-control', 'placeholder' => 'Nombre...' ]) !!}
    		</div>
    		<div class="col-3">
    			{!! Form::text('last_name', Request::get('last_name'), ['class' => 'form-control', 'placeholder' => 'Apellido...']) !!}
    		</div>
    		<div class="col-3">
    			{!! Form::text('dni_number', Request::get('dni_number'), ['class' => 'form-control', 'placeholder' => 'Número de documento...']) !!}
    		</div>
    		<div class="col-2">
    			{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}
    		</div>
    	</div>
    {!! Form::close() !!}
    <br> 
    <p class="text-center"> @include('flash::message') </p>
    <br>
    <div class="container">
	    <div class="row">
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

			    	@permission('patients_show')
			    	<div class="col-1">
			    		<a href="{{ route('patients.show', $patient->id) }}">
			    			<button class="btn btn-success">Ver</button>
			    		</a>
			    	</div>
			    	@endpermission

			    	@permission('patients_update')
			    	<div class="col-1">
			    		<a href="{{ route('patients.edit', $patient->id) }}">
			    			<button class="btn btn-warning">Editar</button>
			    		</a>
			    	</div>
			    	@endpermission

			    	@permission('patients_destroy')
			    	<div class="col-1">
			    		<a href="{{ route('patients.destroy', $patient->id) }}">
			    			<button class="btn btn-danger" onclick="return confirm('¿Está seguro?')">Borrar</button>
			    		</a>
			    	</div>
			    	@endpermission
			    	
			    </li>
				@endforeach
			</ul>
		</div>
	</div>
	<br>
	<div class="row container-fluid justify-content-center align-items-center"> {{ $patients->appends(['first_name' => Request::get('first_name'), 'last_name' => Request::get('last_name'), 'dni_number' => Request::get('dni_number')])->links() }} </div>
@endsection

