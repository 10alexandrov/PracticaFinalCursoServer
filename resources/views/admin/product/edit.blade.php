
@extends('plantilla.plantilla')
@section('contenido')


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Editar producto</title>

    </head>


<body>
<form class="info-container AW-center" action="{{ route('product.update', $producto->product_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    <div>
        <div class="row mt-3 mb-3">
            <h1 class="col-12 col-sm-7 col-md-7 col-lg-8">Editar producto</h1>
            <div class="col-12 col-sm-5 col-md-5 col-lg-4 d-flex justify-content-between">
              <div class="mt-2" >
                <button type="submit" class="btn btn-primary btn-AW">Editar</button>
              </div>
              <div  class="ms-5 mt-2" >
                <a href="{{route('product.index')}}">
                    <button type="button" class="btn btn-info btn-AW">Volver</button>
                </a>
              </div>
            </div>
        </div>

<div class="form">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-4 desctop-color pb-2">
        <label for="nombre" class="form-label-AW">Nombre producto</label>
        <div>
          <input type="text" name="p_nombre" placeholder="Nombre..." class="form-control col-md-6" value="{{ $producto->p_nombre }}">
            @if ($errors->has('p_nombre'))
                <div class="text-danger">
                    {{ $errors->first('p_nombre')}}
                </div>
            @endif
        </div>
      </div>


      <!-- Categoria select -->
      <div class="col-12 col-sm-6 col-md-4 desctop-color pb-2">
        <label for="p_categoria" class="form-label-AW">Categoría</label>
        <div>
          <select name="p_categoria" class="form-control col-md-6">
            <option value="">-- Elije una categoría --</option>
            <option  value="1" {{ $producto->p_categoria == 1 ? 'selected' : '' }}>Bebidas</option>
            <option  value="2" {{ $producto->p_categoria == 2 ? 'selected' : '' }}>Cereales</option>
            <option  value="3" {{ $producto->p_categoria == 3 ? 'selected' : '' }}>Enlatada</option>
            <option  value="4" {{ $producto->p_categoria == 4 ? 'selected' : '' }}>Pasteleria</option>
            <option  value="5" {{ $producto->p_categoria == 5 ? 'selected' : '' }}>Alcohol</option>
            <option  value="6" {{ $producto->p_categoria == 6 ? 'selected' : '' }}>Snack</option>
          </select>
          @if ($errors->has('p_categoria'))
            <div class="text-danger">
                {{ $errors->first('p_categoria')}}
            </div>
        @endif
        </div>
      </div>

      <!--  Activar/desactivar producto -->
      <div class="col-12 col-sm-12 col-md-4 pt-4 mobile-color pb-2">
        <div class="form-check form-check-inline">
          <input type="hidden" name="p_activo" value="0">
          <input
            class="form-check-input"
            name="p_activo"
            type="checkbox"
            id="activeTrue"
            value="1"
            {{ isset($producto->p_activo) && $producto->p_activo ? 'checked' : '' }}
            >
          <label class="form-check-label form-label-AW" for="activeTrue">
            Producto activo
          </label>
        </div>
      </div>


    </div>

    <!-- Description  -->
    <div class="row">
      <div class="pb-3 mobile-color-2">
        <label for="description" class="form-label-AW">Descripcion</label>
        <div class="d-flex col-md-12">
          <input type="text-area"  name="p_description" placeholder="Descripcion..." class="form-control col-md-6"
          @if ($producto->p_description)
            value="{{ $producto->p_description}}"
          @endif
          >
        </div>
      </div>
    </div>

    <!-- Group para demensiones -->
    <div class="row">

      <div class="col-6 col-md-3 mobile-color pb-2">
        <label for="p_longitud" class="form-label">Longitud, mm</label>
        <input type="text" name="p_longitud" placeholder="Longitud..." class="form-control col-md-6" value="{{ $producto->p_longitud }}">
        @if ($errors->has('p_longitud'))
            <div class="text-danger">
                {{ $errors->first('p_longitud')}}
            </div>
        @endif
      </div>

      <div class="col-6 col-md-3 mobile-color pb-2">
        <label for="p_altura" class="form-label">Altura, mm</label>
        <input type="text" name ="p_altura" placeholder="Altura..." class="form-control col-md-6" value="{{ $producto->p_altura }}">
        @if ($errors->has('p_altura'))
            <div class="text-danger">
                {{ $errors->first('p_altura')}}
            </div>
        @endif
      </div>

      <div class="col-6 col-md-3 desctop-color pb-2">
        <label for="p_ancho" class="form-label">Anchura, mm</label>
        <input type="text" name="p_ancho" placeholder="Anchura..." class="form-control col-md-6" value="{{ $producto->p_ancho }}">
        @if ($errors->has('p_ancho'))
            <div class="text-danger">
                {{ $errors->first('p_ancho')}}
            </div>
        @endif
      </div>

      <div class="col-6 col-md-3 desctop-color pb-2">
        <label for="p_peso" class="form-label">Peso, gr</label>
        <input type="text" name="p_peso" placeholder="Peso..." class="form-control col-md-6" value="{{ $producto->p_peso }}">
        @if ($errors->has('p_peso'))
            <div class="text-danger">
                {{ $errors->first('p_peso')}}
            </div>
        @endif
      </div>
    </div>

    <!-- Bloque de precio -->

    <div class="row">
      <div class="col-6 col-md-3 desctop-color-2 pb-2">
        <label for="p_precio_compra" class="form-label">Precio de Compra, euro</label>
        <input type="text" name="p_precio_compra" placeholder="Precio de Compra..." class="form-control col-md-6" value="{{ $producto->p_precio_compra }}">
        @if ($errors->has('p_precio_compra'))
            <div class="text-danger">
                {{ $errors->first('p_precio_compra')}}
            </div>
        @endif
      </div>



      <div class="col-6 col-md-3 desctop-color-2 pb-2">
        <label for="p_peso" class="form-label">Precio de Venta, euro</label>
        <input type="text" name="p_precio_venta" placeholder="Precio de Venta..." class="form-control col-md-6" value="{{ $producto->p_precio_venta }}">
        @if ($errors->has('p_precio_venta'))
            <div class="text-danger">
                {{ $errors->first('p_precio_venta')}}
            </div>
        @endif
      </div>

      <div class="col-6 col-md-3 mobile-color-2 pb-2" >
        <label for="p_cantidad_palet" class="form-label">Unidades en palé, ud</label>
        <input type="text" name="p_cantidad_palet" placeholder="Unidades..." class="form-control col-md-6" value="{{ $producto->p_cantidad_palet }}">
        @if ($errors->has('p_cantidad_palet'))
            <div class="text-danger">
                {{ $errors->first('p_cantidad_palet')}}
            </div>
        @endif
      </div>


      <div class="col-6 col-md-3 mobile-color-2 pb-2" >
        <label for="p_peso" class="form-label">Código de barras</label>
        <input type="text" name="p_codigo" placeholder="Codigo..." class="form-control col-md-6" value="{{ $producto->p_codigo }}">
        @if ($errors->has('p_codigo'))
            <div class="text-danger">
                {{ $errors->first('p_codigo')}}
            </div>
        @endif
      </div>
    </div>

    <!-- Bloque de image -->

    <div class="form-group">
      <div class="row mobile-color p-2">
        <div class="col-12 col-sm-6">
          <label for="name">Imagen</label>
          <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
          <br><br>
          <img id="imagePreview" src="#" alt="Image Preview" style="display:none; max-width: 200px; max-height: 200px;">
        </div>
      </div>
    </div>
</div>
</form>
</body>

@endsection

<script>
    function previewImage(event) {
        const reader = new FileReader();
        const imageField = document.getElementById("imagePreview");

        reader.onload = function(){
            if(reader.readyState == 2){
                imageField.style.display = "block";
                imageField.src = reader.result;
            }
        }

        reader.readAsDataURL(event.target.files[0]);
    }
</script>
</html>

