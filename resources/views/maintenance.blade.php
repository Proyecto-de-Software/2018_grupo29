@extends('layouts.general')

@section('content')
    @guest
    <h1 class="text-center">Sitio en mantenimiento</h1>

  @endguest

  @auth
    <br>
    <h1 class="text-center">¡Bienvenido/a  nuevamente {{Auth::user()->first_name}}!</h1>
    <h4 class="text-center">Has iniciado sesión correctamente</h4>
    <br><br><br>
    <p class="text-center">
      En la barra de navegación de arriba encontrará todas 
      las acciones que puede hacer acorde a su rol asignado
    </p>
    <br>
    <p class="text-center">
      Si considera que debería tener acceso a cierta acción y no la tiene, 
      por favor comuníquese con <strong> RRHH@hospitalkorn.com</strong>
      para que podamos ayudarle.
    </p>
    <br>
    <p class="text-center">¡Gracias!</p>

  @endauth
@endsection
