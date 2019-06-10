@extends('layouts.general')

@section('title','Permisos de rol')

@section('content')
	
	<h2 class="text-center">Permisos del rol "{{ $role->name }}"</h2>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-sm-5">
				<h4 class="text-center">Permisos actuales</h4>
				<ul class="list-group ">
					@foreach ($permissions as $permission)
						<li class="list-group-item row d-flex text-center">
							<div class="col-sm-5"> 
								{{ $permission->display_name }}
							</div>
							<div class="col-sm-2"></div>
							<div class="col-sm-5"> 
								<a href="{{ route('roles.permissions.remove',[$role->id,$permission->id]) }}">
									<button class="btn btn-danger"> Desasignar </button>
								</a>
							</div>
						</li>
					@endforeach		
				</ul>
			</div>
			<div class="col-sm-2"> </div>
			<div class="col-sm-5">
				<h4 class="text-center">Otros roles</h4>
				<ul class="list-group ">
					@foreach ($other_permissions as $other_permission)
						<li class="list-group-item row d-flex text-center">
							<div class="col-sm-5"> 
								{{ $other_permission->display_name }}
							</div>
							<div class="col-sm-2"></div>
							<div class="col-sm-5"> 
								<a href="{{ route('roles.permissions.add',[$role->id,$other_permission->id]) }}">
									<button class="btn btn-success"> Asignar </button>
								</a>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
@endsection