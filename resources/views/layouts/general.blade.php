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

	<!-- Para ver si funciona el dropdown -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
	  <ul class="navbar-nav">
	  	<a class="navbar-brand" href="#">Hospital Dr. Alejandro Korn </a>
	    <li class="nav-item active">
	      <a class="nav-link" href="{{ route('patients.index') }}">Pacientes</a>
	    </li>
	    <li class="nav-item active">
	      <a class="nav-link" href="#">Consultas</a>
	    </li>
		<li class="nav-item dropdown active">
			<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" aria-expanded="false">Administración</a>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="#">Usuarios</a>	
				<a class="dropdown-item" href="#">Roles</a>	
				<a class="dropdown-item" href="#">Reportes</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#">Configuración</a>	
			</div>
		</li>
	  </ul>
	</nav>
	<br><br>
	@yield('content')
</body>
</html>