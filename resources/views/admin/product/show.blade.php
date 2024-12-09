@extends('plantilla.plantilla')
@section('contenido')


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Show producto</title>

    </head>


<body>
    <div class="info-container AW-center">
        <div class="row justify-content-between">
            <h1 class = "col-12 col-md-7 pt-1"> {{ $producto->p_nombre}}</h1>
            <div class="col-12 col-md-5 d-flex justify-content-between pt-2">
                <div class="m-10">
                    <a  href="{{ route('product.edit', $producto->product_id)}}">
                        <button class='m-100 btn btn-warning'>Editar </button>
                    </a>
                </div>
                <div class="m-10">
                        <button class='m-100 btn btn-danger' id="desactivar">Desactivar</button>
                </div>
                <div class="m-10">
                    <a  href="{{ route('product.index')}}">
                        <button class='m-100 btn btn-primary'>Volver </button>
                    </a>
                </div>
            </div>
        </div>



        <div class="descripcion mb-2">{{$producto->p_descripcion}}</div>
        <div class="row d-flex">
          <div class="col-12 col-sm-8 mt-4">
            <table class="table table-striped table-bordered">
                <thead class="table-primary">
                  <tr>
                    <th>Precio de compra</th>
                    <th>Precio de venta</th>
                    <th>Activo</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> {{$producto->p_precio_compra}}</td>
                    <td> {{$producto->p_precio_venta}}</td>
                    @if ($producto->p_activo)
                        <td style="color:green"> Activo</td>
                    @else
                        <td style="color:red"> Inactivo</td>
                    @endif
                  </tr>
                </tbody>
              </table>
              <h5>Cantidad</h5>
              <table class="table table-striped table-bordered">
                <thead class="table-primary">
                  <tr>
                    <th>En Almacen</th>
                    <th>En Entrega</th>
                    <th>Reservado</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> {{$producto->p_cantidad_almacen}}</td>
                    <td> {{$producto->p_cantidad_entrega}}</td>
                    <td> {{$producto->p_cantidad_reservado}}</td>
                  </tr>
                </tbody>
              </table>

          </div>
          <div class="col-4 desktop-version">
            <div class="image">
                <img src="{{ $producto->p_foto}}">
            </div>
          </div>
        </div>
        <h5>Demenciones</h5>
            <div class="desktop-version">
              <table class="table table-striped table-bordered">
                <thead class="table-primary">
                  <tr>
                    <th>Altura, mm</th>
                    <th>Anchura, mm</th>
                    <th>Longitud, mm</th>
                    <th>Peso, gr</th>
                    <th>Unidades en palet, ud</th>
                    <th>Peso de palet, kg</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> {{$producto->p_altura}}</td>
                    <td> {{$producto->p_ancho}}</td>
                    <td> {{$producto->p_longitud}}</td>
                    <td> {{$producto->p_peso}}</td>
                    <td> {{$producto->p_cantidad_palet}}</td>
                    <td> {{$producto->p_peso_palet}}</td>
                  </tr>
                </tbody>
              </table>
            </div>


              <!-- Mobile versin-->
            <div class="mobile-version">
              <table class="table table-striped table-bordered">
                <thead class="table-primary">
                  <tr>
                    <th>Altura, mm</th>
                    <th>Anchura, mm</th>
                    <th>Longitud, mm</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> {{$producto->p_altura}}</td>
                    <td> {{$producto->p_ancho}}</td>
                    <td> {{$producto->p_longitud}}</td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-striped table-bordered">
                <thead class="table-primary">
                  <tr>
                    <th>Peso, gr</th>
                    <th>Unidades en palet, ud</th>
                    <th>Peso palet, kg</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> {{$producto->p_peso}}</td>
                    <td> {{$producto->p_cantidad_palet}}</td>
                    <td> {{$producto->p_peso_palet}}</td>
                  </tr>
                </tbody>
              </table>
              <div>
                <div class="image">
                    <img src="{{ $producto->p_foto}}">
                </div>
              </div>
            </div>
    </div>

    <!--Popup ventana-->
    <div class="d-none popup2" id='popup'>
      <p>Desea desactivar producto: {{$producto->p_nombre}}</p>
      <div class="d-flex buttons justify-content-around">
        <form action="{{ route('product.destroy', $producto->product_id)}}" method="POST">
            @method('DELETE')
            @csrf
            <button class="btn m-100 btn-danger">Desactivar </button>
        </form>
        <button  class="btn btn-AW btn-dark m-auto" id="cerrar">Cerrar </button>
      </div>
    </div>

<style>
    .wrapper-image {
  width: 200px;
  height: 300px;
  overflow: hidden;
}

.img-AW {
  width:100%;
  height: 100%;
  object-fit: contain;

}

.mobile-version {
  display: none;
}

@media screen and (max-width:576px) {

  .mobile-version {
    display: block;
  }

  .desktop-version {
    display: none;
  }
}

//   Popup ventanas

.popup {
  position: absolute;
  top: 10%;
  left: 35%;
  padding: 10px;
  width: 30%;
  height: 65%;
  background-color: white;
  border: 1px solid black;
  box-shadow: 0 0 30px rgba(0, 0, 0, 0.9);
}


.popup2 {
  position: absolute;
  top: 25%;
  left: 35%;
  padding: 10px;
  width: 30%;
  height: 30%;
  background-color: white;
  border: 1px solid black;
  box-shadow: 0 0 30px rgba(0, 0, 0, 0.9);
}

.popup2 p {
  font-size: 1.5rem;
  text-align: center;
  margin-bottom: 2px;
}

.buttons {
  position: absolute;
  bottom: 5px;
  width: 93%;
}

.mobileVisible {
  display: none;
}

.mobileInvisible {
  display: block;
}

.mobileInvisibleTable {
  display: table-cell;
}

@media screen and (max-width:1050px) {
  .popup2 {
    top: 25%;
    left: 35%;
    width: 40%;
    height: 30%;
  }

  .popup2 p {
    font-size: 1.5rem;
    margin-bottom: 2px;
  }

  .popup {
    top: 20%;
    left: 30%;
    padding: 10px;
    width: 40%;
    height: 65%;
  }
}

@media screen and (max-width:850px) {
  .popup2 {
    top: 25%;
    left: 35%;
    padding: 10px;
    width: 50%;
    height: 30%;
  }

  .popup2 p {
    font-size: 1.5rem;
  }
}

@media screen and (max-width:767px) {

  .popup2 {
    left: 20%;
    padding: 10px;
    width: 60%;
    height: 35%;
  }

  .popup2 p {
    font-size: 1.4rem;
  }

  .popup {
    top: 20%;
    left: 20%;
    width: 60%;
  }
}

@media screen and (max-width:576px) {

  .popup2 {
    left: 10%;
    padding: 10px;
    width: 80%;
    height: 40%;
  }

  .popup2 p {
    font-size: 1.3rem;
  }

  .popup {
    top: 20%;
    left: 10%;
    width: 80%;
    height: 65%;
  }

  .img-AW {
    max-width: 150px;
  }

  .mobileVisible {
    display: block;
  }

  .mobileInvisible, .mobileInvisibleTable {
    display: none;
  }
}

@media screen and (max-width:767px) {
  table {
    font-size: 2.5vw;
  }
}

@media screen and (max-width:576px) {
  table {
    font-size: 3vw;
  }
}
</style>

<script>

    const button = document.getElementById('desactivar');

    button.addEventListener('click',(event) => {
        const popup = document.getElementById('popup');
        popup.classList.remove('d-none');
        popup.classList.add('d-block');
        console.log('ckick!');

        const cerrar = document.getElementById('cerrar');

        cerrar.addEventListener('click',(event) => {
            popup.classList.remove('d-block');
            popup.classList.add('d-none');
        })
    })


</script>

</html>

@endsection
