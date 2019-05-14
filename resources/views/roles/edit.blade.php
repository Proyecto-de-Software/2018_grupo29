@extends('layouts.general')

@section('title', 'Editar rol')

@section('content')

	<h2 class="text-center"> Editar rol {{ $role->name }}</h2>

	<div class="container">
		<div class="row">
			<div class="col-sm-3"> </div>

			<div class="col-sm-6">
				{!! Form::open(['route' => ['roles.update', $role->id]],) !!}
					{{ method_field('PUT') }}
					{!! Form::label('name', 'Nombre'); !!}
					{!! Form::text('name',$role->name,['class' => 'form-control']) !!}
					<br>
					{!! Form::label('description', 'Descripción'); !!}
					{!! Form::textarea('description',$role->description,['class'=>'form-control', 'rows' => 4, 'cols' => 40]) !!}
					<br>
					<div class="row justify-content-center">
						{!! Form::submit('¡Actualizar!', ['class' => 'btn btn-outline-primary text-black btn my-2 my-sm-0 btn-lg']) !!}
					</div>
				{!! Form::close() !!}
			</div>

			<div class="col-sm-3"> </div>
		</div>
	</div>


@endsection