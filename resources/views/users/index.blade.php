@extends('layouts.general')

@section('title', 'Listado de usuarios')

@section('content')
    <h2 class="text-center">Usuarios del sistema</h2>
    <br>
    <hr>
    &nbsp; <a href="{{ route('users.create') }}"> <button class="btn btn-success"> Nuevo usuario </button> </a>
    <br><br>
    {!! Form::open(['route' => 'users.index', 'method' => 'GET', 'class' => 'navbar-form pull-right']) !!}
    	<div class="form-group row">
    		<div class="col-3"> </div>
    		<div class="col-4">
    			{!! Form::text('username', Request::get('username'), ['class' => 'form-control', 'placeholder' => 'Nombre de usuario...' ]) !!}
    		</div>
    		<div class="col-2">
    			{!! Form::select('is_active', ['1' => 'Sí', '0' => 'No'], Request::get('is_active'), ['placeholder' => '¿Está activo?...', 'class' => 'form-control']); !!}
    		</div>
       		<div class="col-2">
    			{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}
    		</div>
    	</div>
    {!! Form::close() !!}
    <br> 
    <p class="text-center"> @include('flash::message') </p>
    <br>
    <div class="container">
	    <div class="row">
	    	<ul class="list-group" style="width: 100%">
		    	<li class="list-group-item row d-flex text-center">
		    		<div class="col-2 text-info">Nombre</div>
		    		<div class="col-2 text-info">Apellido</div>
		    		<div class="col-2 text-info">¿Está activo?</div>
		    		<div class="col-3 text-info">Email</div>
		    		<div class="col-1 text-info"></div>
		    		<div class="col-1 text-info"></div>
		    		<div class="col-1 text-info"></div>
		    	</li>
			    @foreach ($users as $user)
			    <li class="list-group-item row d-flex text-center">
			    	<div class="col-2"> {{ $user->first_name }} </div>
			    	<div class="col-2"> {{ $user->last_name }} </div>
			    	<div class="col-2">
			    		@if ($user->is_active == 1)
			    			Sí
			    		@else
			    			No
			    		@endif
			    	</div>
			    	<div class="col-3"> {{ $user->email }} </div>
			    	<div class="col-1">
			    		<a href="{{ route('users.show', $user->id) }}">
			    			<button class="btn btn-success">Ver</button>
			    		</a>
			    	</div>
			    	<div class="col-1">
			    		<a href="{{ route('users.edit', $user->id) }}">
			    			<button class="btn btn-warning">Editar</button>
			    		</a>
			    	</div>
			    	<div class="col-1">
			    		<a href="{{ route('users.destroy', $user->id) }}">
			    			<button class="btn btn-danger" onclick="return confirm('¿Está seguro?')">Borrar</button>
			    		</a>
			    	</div>
			    </li>
				@endforeach
			</ul>
		</div>
	</div>
	<br>
	<div class="row container-fluid justify-content-center align-items-center"> 
		{{ $users->links() }} 
	</div>
@endsection

