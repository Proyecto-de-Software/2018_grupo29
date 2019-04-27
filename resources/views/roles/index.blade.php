@extends('layouts.general')

@section('title','Listado de roles')

@section('content')
	<h2 class="text-center"> Listado de Roles</h2>
	<br>
	<hr>
	&nbsp;
	<a href="#"> 
		<button class="btn btn-success"> Nuevo rol </button>
	</a>
	<br><br>
	<div class="container">
		<div class="row">
			<ul class="list-group" style="width: 100%">
		    	<li class="list-group-item row d-flex text-center">
					<div class="col-sm-2 text-info">Nombre</div>
					<div class="col-sm-6 text-info">Descripción</div>
					<div class="col-sm-2"></div>
					<div class="col-sm-1"></div>
					<div class="col-sm-1"></div>
				</li>
				@foreach ($roles as $rol)
				<li class="list-group-item row d-flex text-center">
					<div class="col-sm-2">{{ $rol->name }}</div>
					<div class="col-sm-6">{{ $rol->description }}</div>
					<div class="col-sm-2">
						<button class="btn btn-success">Ver permisos</button>
					</div>
					<div class="col-sm-1">
						<button class="btn btn-warning">Editar</button>
					</div>
					<div class="col-sm-1">
						<button class="btn btn-danger">Borrar</button>
					</div>
				</li>
				@endforeach
			</ul>
		</div>
	</div>
@endsection