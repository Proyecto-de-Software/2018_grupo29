@extends('layouts.general')

@section('title','Nuevo rol')

@section('content')
	
	<h2 class="text-center">Nuevo rol</h2>

	<div class="container">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				{!! Form::open(['route' => 'roles.store']) !!}

					{!! Form::label('name', 'Nombre'); !!}
					{!! Form::text('name',null,['class' => 'form-control']) !!}
					<br>
					{!! Form::label('description', 'Descripción'); !!}
					{!! Form::textarea('description',null,['class'=>'form-control', 'rows' => 4, 'cols' => 40]) !!}
					<br>
					{{ Form::label('Permisos', "Permisos") }}
					<br>
					@foreach ($permissions as $permission)
						
						{{ Form::checkbox('permission[]', $permission->id) }}
						{{ Form::label('name', "$permission->name") }}
						<br>

					@endforeach
					<br>
					<div class="row justify-content-center">
						{!! Form::submit('¡Listo!', ['class' => 'btn btn-outline-primary text-black btn my-2 my-sm-0 btn-lg']) !!}
					</div>


				{!! Form::close() !!}
			</div>
			<div class="col-sm-3"></div>
		</div>
	</div>

@endsection