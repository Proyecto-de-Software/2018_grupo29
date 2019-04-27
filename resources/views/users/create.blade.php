@extends('layouts.general')

@section('title', 'Crear nuevo usuario')

@section('content')
	<h2 class="text-center"> Nuevo usuario </h2>

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
   
	{!! Form::open(['route' => 'users.store']) !!}
	@csrf
	<input type="hidden" name="is_active" value="1">
	<div class="form-row">	
		<div class="form-group col-md-3"> </div>
		<div class="form-group col-md-6">
	    	{!! Form::label('first_name', 'Nombre') !!}
	    	{!! Form::text('first_name', null, ['class' => 'form-control', 'required']) !!}
	    	<br>
	    	{!! Form::label('last_name', 'Apellido') !!}	
			{!! Form::text('last_name', null, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('email', 'Correo electrónico') !!}	
			{!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('username', 'Nombre de usuario') !!}	
			{!! Form::text('username', null, ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('password', 'Contraseña') !!}	
			{!! Form::password('password', ['class' => 'form-control', 'required']) !!}
			<br>
			{!! Form::label('password_confirmation', 'Confirmar contraseña') !!}	
			{!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
			<br>
	    </div>
	    <div class="form-group col-md-3"> </div>
	</div>
	<div class="row justify-content-center">
		{!! Form::submit('¡Listo!', ['class' => 'btn btn-outline-primary text-black btn my-2 my-sm-0 btn-lg']) !!}
	</div>
	{!! Form::close() !!}
	
		
@endsection