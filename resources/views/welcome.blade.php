@extends('plantilla.plantilla')
@section('contenido')

<style>

  img, svg {
    vertical-align: middle;
  }

  .img, .wrapper {
  align-items: center;
  justify-content: center;
  text-align: center;
}

.AW-center {
  text-align: center;
}

.AW-img {
  width: 30%;
}

.mobile-menu {
  display: none;
}


@media screen and (max-width:767px) {

  .sidebar {
    display: none;
  }

  .mobile-menu {
    display: block;
  }

  .AW-img {
    width: 40%;
  }

}

</style>


    <div class = "info-container AW-center">
      <div class = "d-flex img m-auto pt-5">
        <!-- <img src="./assets/1a_logotype.jpg" style="width: 40%;"> -->
        <img class="AW-img" src="https://omnigena.info/img/logo/1a_logotype.jpg">
      </div>
      <h1 class="mt-5 m-auto">BIENVENIDO a ALMACEN</h1>

      <h5 class="mt-4 AW-center">V. 1.2.15.1</h5>
      <h5 class="mt-1">ALEXAWEB 2024</h5>
    </div>


  @endsection
