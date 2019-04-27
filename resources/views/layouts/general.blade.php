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
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  <a class="navbar-brand" href="#">Hospital Dr. Alejandro Korn</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  
	  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
	  	@if (Auth::user())
	    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">      
	      <li class="nav-item active">
		      <a class="nav-link" href="{{ route('patients.index') }}">Pacientes</a>
		    </li>
		    <li class="nav-item active">
		      <a class="nav-link" href="#">Consultas</a>
		    </li>
			<li class="nav-item dropdown active">
				<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" aria-expanded="false">Administración</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="{{ route('users.index') }}">Usuarios</a>	
					<a class="dropdown-item" href="#">Roles</a>	
					<a class="dropdown-item" href="#">Reportes</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">Configuración</a>	
				</div>
			</li>
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