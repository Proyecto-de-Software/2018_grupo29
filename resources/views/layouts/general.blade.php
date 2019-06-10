<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>

	<link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('plugins/bootstrap/css/bootstrap-grid.css') }}" rel="stylesheet">
	<link href="{{ asset('plugins/bootstrap/css/bootstrap-grid.min.css') }}" rel="stylesheet">
	<link href="{{ asset('plugins/bootstrap/css/bootstrap-reboot.css') }}" rel="stylesheet">
	<link href="{{ asset('plugins/bootstrap/css/bootstrap-reboot.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTables/datatables.min.css') }}"/>
 
	<!-- Para ver si funciona el dropdown -->
	<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<!-- Select2 -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	
	<script type="text/javascript" src="{{ asset('js/select2.js') }}"></script>
	<script>
		var app_url='{{ url("/") }}';
	</script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  <a class="navbar-brand" href="{{ route('home') }}">Hospital Dr. Alejandro Korn</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  
	  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
	  	@if (Auth::user())
	    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">   
	    	@permission('patients_index')   
		      <li class="nav-item active">
			      <a class="nav-link" href="{{ route('patients.index') }}">Pacientes</a>
			    </li>
			@endpermission
		    @permission('consultations_index')
		    <li class="nav-item active">
		      <a class="nav-link" href="{{ route('consultations.index') }}">Consultas</a>
		    </li>
		    @endpermission

		    @permission('users_index', 'roles_index', 'reports_index', 'configuration_index')
			<li class="nav-item dropdown active">
				<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" aria-expanded="false">Administración</a>
				<div class="dropdown-menu">
					
					@permission('users_index')
						<a class="dropdown-item" href="{{ route('users.index') }}">Usuarios</a>
					@endpermission	

					@permission('roles_index')
						<a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>	
					@endpermission

					@permission('reports_index')
						<a class="dropdown-item" href="{{ route('reports') }}">Reportes</a>
					@endpermission
					
					@permission('configuration_index')
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{ route('configurations.edit') }}">Configuración</a>
					@endpermission
				</div>
			</li>
			@endpermission
	    </ul>
	    <span class="navbar-text">
		    Bienvenido {{ Auth::user()->first_name }}
		</span>
		&nbsp;&nbsp;&nbsp;
	    <form method="POST" class="form-inline my-2 my-lg-0" action="{{ route('logout') }}">
	      	@csrf
		    <button class="btn btn-primary my-2 my-sm-0" type="submit" onclick="return confirm('¿Está seguro que quiere cerrar sesión?')">Cerrar sesión</button>
	    </form>
	    @else
	    	<ul class="navbar-nav mr-auto mt-2 mt-lg-0"> </ul>
	    	<form method="GET" class="form-inline my-2 my-lg-0" action="{{ route('login') }}">
	    		<button class="btn btn-primary my-2 my-sm-0" type="submit">Iniciar sesión</button>
	    	</form>
	    	&nbsp;
	    	<form method="GET" class="form-inline my-2 my-lg-0" action="{{ route('register') }}">
	    		<button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Registrarse</button>
	    	</form>
	    @endif
	  </div>
	</nav>
	
	<br><br>
	@yield('content')
	<br> <br> <br>
	<footer class="footer bg-dark">
      <div class="container">
        <span class="text-light">Hospital Dr. Alejandro Korn</span>
        <span class="text-light float-right">v.3.0</span>
      </div>
    </footer>
</body>
</html>