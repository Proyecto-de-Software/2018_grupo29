@extends('layouts.general')

@section('title', 'Listado de pacientes')

@section('content')
    <h2 class="text-center">Pacientes del Hospital</h2>
    <br>
    <div class="row container-fluid">
    	<ul class="list-group" style="width: 100%">
	    	<li class="list-group-item row d-flex text-center">
	    		<div class="col-2 text-info">Nombre</div>
	    		<div class="col-2 text-info">Apellido</div>
	    		<div class="col-1 text-info">Género</div>
	    		<div class="col-1 text-info">Localidad</div>
	    		<div class="col-4 text-info">Fecha y lugar de nacimiento</div>
	    		<div class="col-1 text-info"></div>
	    		<div class="col-1 text-info"></div>
	    	</li>
		    @foreach ($patients as $patient)
		    <li class="list-group-item row d-flex text-center">
		    	<div class="col-2"> {{ $patient->first_name }} </div>
		    	<div class="col-2"> {{ $patient->last_name }} </div>
		    	<div class="col-1"> {{ $patient->gender->name }} </div>
		    	<div class="col-1"> Estático por ahora </div>
		    	<div class="col-4"> {{ $patient->birthdate }} {{ $patient->place_of_birth }} </div>
		    	<div class="col-1"> <button class="btn btn-warning">Editar</button> </div>
		    	<div class="col-1"> <button class="btn btn-danger">Borrar</button> </div>
		    </li>
			@endforeach
		</ul>
	</div>
@endsection

