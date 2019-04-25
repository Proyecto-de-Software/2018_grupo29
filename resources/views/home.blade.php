@extends('layouts.general')

@section('content')
    @guest
        <div class="row container-fluid alMedio">
    <div class="col-sm-12 text-center">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="{{ asset('/img/TelSlide.jpg') }}" alt="First slide">
       <div class="carousel-caption back bg-info" style="opacity: 0.7">
        <h4 class="text-dark">TURNOS AL 0800-222-1212</h4>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="{{ asset('/img/TerapInfSlide.jpg') }}" alt="Second slide">
       <div class="carousel-caption back bg-info"  style="opacity: 0.7">
          <h4 class="text-dark">UNIDAD DE TERAPIA INTENSIVA PEDIÁTRICA</h4>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="{{ asset('/img/ResonadorSlide.jpg') }}" alt="Third slide">
       <div class="carousel-caption back bg-info"  style="opacity: 0.7">
          <h4 class="text-dark">INCORPORAMOS UN NUEVO RESONADOR</h4>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Siguiente</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Anterior</span>
  </a>
</div>
</div>

</div>
<br><br><br><br>

<div class="row container-fluid">
  <div class="col-sm-4">
    <div class="container">
      <img src="{{ asset('/img/recepcion.jpg') }}" class="image" style="width:100%">
      <div class="middle">
        <div class="text">Las mejores instalaciones</div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="container">
      <img src="{{ asset('/img/estetoscopio.jpg') }}" class="image" style="width:100%">
      <div class="middle">
        <div class="text">Servicios ambulatorios</div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="container">
      <img src="{{ url('img/doctor.jpg') }} " class="image" style="width:100%">
      <div class="middle">
        <div class="text">Grandes profesionales</div>
      </div>
    </div>
  </div>
</div>

    @endguest
@endsection
