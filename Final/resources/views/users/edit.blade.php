@extends('layouts.general')

@section('title', 'Editar usuario')

@section('content')

	<h2 class="text-center"> Editar usuario {{ $user->first_name }} {{ $user->last_name }}</h2>
	@if ($errors->any())
	    <div class="alert alert-danger">
	    	<p>El formulario no cumple con las siguientes condiciones: </p>
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif
	<div class="container">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				{!! Form::open(['route' => ['users.update', $user->id]]) !!}
					{{ method_field('PUT') }}
					{!! Form::hidden('id', $user->id) !!}

					{!! Form::label('first_name', 'Nombre') !!}
					{!! Form::text('first_name', $user->first_name, ['class' => 'form-control', 'required']) !!}
					<br>
					{!! Form::label('last_name', 'Apellido') !!}	
					{!! Form::text('last_name', $user->last_name, ['class' => 'form-control', 'required']) !!}
					<br>
					<div class="row justify-content-center">
						{!! Form::submit('Actualizar', ['class' => 'btn btn-outline-primary text-black btn my-2 my-sm-0 btn-lg']) !!}
					</div>
				{!! Form::close() !!}
			</div>
			<div class="col-sm-3"></div>
		</div>
	</div>


@endsection