@extends('layouts.general')

@section('title','Permisos de rol')

@section('content')
	
	<h2 class="text-center">Permisos de {{ $role->name }}</h2>

	<div class="container">
		<div class="row">
			<ul class="list-group" style="width: 100%">
		    	<li class="list-group-item row d-flex text-center">
					<div class="col-sm-2 text-info">Nombre</div>
					<div class="col-sm-8 text-info">Descripción</div>
					<div class="col-sm-1"></div>
					<div class="col-sm-1"></div>
				</li>
				@foreach ($permissions as $permission)
				<li class="list-group-item row d-flex text-center">
					<div class="col-sm-2">{{ $permission->name }}</div>
					<div class="col-sm-8">{{ $permission->description }}</div>
					<div class="col-sm-1"></div>
					<div class="col-sm-1">
						<button class="btn btn-danger">Borrar</button>
					</div>
				</li>
				@endforeach
			</ul>
		</div>
	</div>
@endsection