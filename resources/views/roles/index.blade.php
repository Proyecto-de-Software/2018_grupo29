@extends('layouts.general')

@section('title','Listado de roles')

@section('content')
	<h2 class="text-center"> Listado de Roles</h2>
	<br>
	<hr>
	&nbsp;

	@permission('roles_new')
		<a href="{{ route('roles.create') }}"> 
			<button class="btn btn-success"> Nuevo rol </button>
		</a>
	@endpermission

	<p class="text-center"> @include('flash::message') </p>
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

					@permission('roles_show')
						<div class="col-sm-2">
							<a href="{{ route('roles.show', $rol->id) }}"><button class="btn btn-success">Ver permisos</button> </a>
						</div>
					@endpermission

					<!-- El rol de administrador no deberia editarse ni borrarse -->
					@unless ($rol->name == 'Administrador')

						@permission('roles_update')
							<div class="col-sm-1">
								<button class="btn btn-warning">Editar</button>
							</div>
						@endpermission

						@permission('roles_destroy')
							<div class="col-sm-1">
								<a onclick="return confirm('¿Está seguro?')" href="{{ route('roles.destroy', $rol->id) }}"><button class="btn btn-danger">Borrar</button> </a>
							</div>
						@endpermission

					@endunless
				</li>
				@endforeach
			</ul>
		</div>
	</div>
@endsection