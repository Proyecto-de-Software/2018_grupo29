@extends('layouts.general')

@section('title', 'Roles de usuario')

@section('content')
	
	<h2 class="text-center"> Agregar/quitar roles a {{ $user->first_name }} {{ $user->last_name}} </h2>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-sm-1"> </div>
			<div class="col-sm-4 text-center">
				<h4> Roles actuales </h4>
				<ul class="list-group ">
					@foreach ($roles as $rol)
					<li class="list-group-item row d-flex text-center">
						<div class="col-5">
							{{$rol->name}}
						</div>
						<div class="col-2"></div>
						<div class="col-5">
							<button class="btn btn-danger">Desasignar</button>
						</div>
					</li>
					@endforeach
				</ul>
			</div>
			<div class="col-sm-2"> </div>
			<div class="col-sm-4 text-center">
				<h4> Resto de roles </h4>
				<ul class="list-group ">
					<li class="list-group-item row d-flex text-center">
						<div class="col-5">
							Equipo de Guardia
						</div>
						<div class="col-2"></div>
						<div class="col-5">
							<button class="btn btn-success">Asignar</button>
						</div>
					</li>
				</ul>
			</div>
			<div class="col-sm-1"> </div>
		</div>
	</div>

@endsection