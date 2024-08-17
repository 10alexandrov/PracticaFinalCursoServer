<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Crear Producto</title>

    </head>


    <body class="AW-body">
        <div class="main-wrapper">
            <div class ="main-aside">
                @include("include.aside-menu")

            </div>
        </div>
        <div class="main-content">
            <h1> Crear nuevo Producto</h1>

            <div class="form">
                <div class="container mt-5">
                    <div class="table_container">

                        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group m-20">
                                <label for="p_nombre">Nombre producto</label>
                                <input type="text" class="form-control" id="p_nombre" name="p_nombre" value="{{ old('p_nombre') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="p_categoria">Categoria</label>
                                <select name="p_categoria" required>
                                    <option  value="1">Bebidas</option>
                                    <option  value="2">Cereales</option>
                                    <option  value="3">Enlatada</option>
                                    <option  value="4">Pasteleria</option>
                                    <option  value="5">Alcohol</option>
                                    <option  value="6">Snack</option>
                                </select>
                            </div>

                            <div class="form-group m-20">
                                <label for="p_ancho">Anchura del producto</label>
                                <input type="number" class="form-control" id="p_ancho" name="p_ancho" value="{{ old('p_ancho') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="p_longitud">Longitud del producto</label>
                                <input type="number" class="form-control" id="p_longitud" name="p_longitud" value="{{ old('p_longitud') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="p_altura">Altura del producto</label>
                                <input type="number" class="form-control" id="p_altura" name="p_altura" value="{{ old('p_altura') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="p_peso">Peso del producto</label>
                                <input type="number" class="form-control" id="p_peso" name="p_peso" value="{{ old('p_peso') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="p_cantidad_almacen">Cantidad en almacen</label>
                                <input type="number" class="form-control" id="p_cantidad_almacen" name="p_cantidad_almacen" value="{{ old('p_cantidad_almacen') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="p_cantidad_entrega">Cantidad en entrega</label>
                                <input type="number" class="form-control" id="p_cantidad_entregan" name="p_cantidad_entrega" value="{{ old('p_cantidad_entrega') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="p_cantidad_reservado">Cantidad reservado</label>
                                <input type="number" class="form-control" id="p_cantidad_reservado" name="p_cantidad_reservado" value="{{ old('p_cantidad_reservado') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="p_cantidad_enviado">Cantidad enviado</label>
                                <input type="number" class="form-control" id="p_cantidad_enviado" name="p_cantidad_enviado" value="{{ old('p_cantidad_enviado') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="p_precio_compra">Precio de compra</label>
                                <input type="number" class="form-control" id="p_precio_compra" name="p_precio_compra" value="{{ old('p_precio_compra') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="p_precio_venta">Precio de venta</label>
                                <input type="number" class="form-control" id="p_precio_venta" name="p_precio_venta" value="{{ old('p_precio_venta') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="p_codigo">Codigo de barra</label>
                                <input type="text" class="form-control" id="p_codigo" name="p_codigo" value="{{ old('p_codigo') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="image">Subir Imagen:</label>
                                <input type="file" id="image" name="image" accept="image/*" required onchange="previewImage(event)">
                                <br><br>
                                <img id="imagePreview" src="#" alt="Image Preview" style="display:none; max-width: 200px; max-height: 200px;">
                            </div>

                             <button class='m-20 btn-new'>Crear nuevo poducto </button>
                         </form>
                    </div>
                </div>
            </div>
        </div>



</body>

<style>

    .AW-body {
        display:flex;
    }

    .main-content {
        text-align: center;
        width:100%;
    }

    .btn-new {
    border-radius: 10px;
    color: white;
    transition: .2s linear;
    background: #0B63F6;
    }

    .btn-new:hover {
        box-shadow: 0 0 0 2px white, 0 0 0 4px #3C82F8;
    }

    .table_container {
        display: flex;
        justify-content: center;
        align-items: baseline;
    }

    .m-20 {
    margin-top: 20px;
}
</style>

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
