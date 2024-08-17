<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Product</title>

    </head>
    <body class="AW-body">
        <div class="main-wrapper">
            <div class ="main-aside">
                @include("include.aside-menu")

            </div>
        </div>
        <div class="main-content">
            <h1> Productos </h1>
            <div class='find_container'>
                <form action="{{ route('admin.productos.find')}}" method="POST">
                    @csrf
                    <div class="d-flex" style="margin-left: 100px;">
                        <div class="form-group m-20">
                            <label for="find_categoria">Categoria</label>
                            <select name="find_categoria">
                                <option value="">Elije categoria</option>
                                <option  value="1">Bebidas</option>
                                <option  value="2">Cereales</option>
                                <option  value="3">Enlatada</option>
                                <option  value="4">Pasteleria</option>
                                <option  value="5">Alcohol</option>
                                <option  value="6">Snack</option>
                            </select>
                        </div>
                        <div class="form-group m-20">
                            <label for="p_nombre">Buscar por nombre</label>
                            <input type="text" class="form-control" id="partial" name="partial">
                            <input type="hidden" name="rute" value="pedido">
                        </div>
                        <button>Filtrar </button>
                    </div>
                </form>
            </div>
            <div class="table_container">
                <table>
                    <tr>
                        <th> Producto </th>
                        <th> Categoria </th>
                        <th> Cantidad </th>
                        <th> Mostrar </th>
                        <th> Editar </th>
                        <th> Borrar </th>
                    </tr>
                    @foreach ($productos as $producto)
                        <tr>
                            <td> {{$producto->p_nombre}} </td>
                            <td> {{$producto->p_categoria}} </td>
                            <td> {{$producto->p_cantidad_almacen}} </td>
                            <td> <a href='#'>Mostrar </a></td>
                            <td> <a class="anadir" id="{{$producto->id_product}}" href='#'>Anadir </a></td>
                            <td>
                                <form action="#" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button>Borrar </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                </table>
            </div>

            <div class="linea"></div>

            <div class="table_container">
                <table>
                    <thead>
                        <tr class="factura-nueva">
                            <th> Producto </th>
                            <th> Categoria </th>
                            <th> Cantidad </th>
                            <th> Mas </th>
                            <th> Minus </th>
                            <th> Borrar </th>
                        </tr>
                    </thead>
                    <tbody id="factura-nueva">
                        <tr id="factura-nueva"></tr>
                    </tbody>
                </table>
            </div>


            <a  href="{{ route('pedido.facturas.store')}}">
                <button class='m-100'>Crear nuevo pedido </button>
           </a>
        </div>
    </body>
</html>

<style>

    .AW-body {
        display:flex;
    }

    .main-content {
        text-align: center;
        width:100%;
    }

    .table_container {
        display: flex;
        justify-content: center;
        align-items: baseline;
    }

    th, td {
        width: 150px;
        text-align: left;
    }

    td {
        font-weight: 400;
    }

    td a{
        font-weight: 800;
        text-decoration: none;
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

    .m-100 {
        margin-top: 100px;
    }

    .d-flex {
        display: flex;
    }

    .linea {
        width: 50%;
        height: 2px;
        background-color: #666;
        justify-content: center;
        margin: 20px 25%;
    }
</style>

<script>

    // MAIN
    const productos = @json($productos);

    document.addEventListener('DOMContentLoaded', (event) => {
        // Объект для хранения количества нажатий для каждой кнопки
        const clickCounts = [];

                // Get name product by ID
        function getNameProduct (productos, buttonId) {
            console.log(buttonId);
            console.log(productos);
            const producto = productos.find(p=>p.id_product == buttonId);
            return producto ? producto.p_nombre : "sin nombre";
        }
        // get category product by ID
        function getNameCategory (productos, buttonId) {
            const producto = productos.find(p=>p.id_product == buttonId);
            return producto ? producto.p_categoria : "sin categoria";
        }

        // Функция для обработки нажатий на кнопки anadir
        function handleButtonClick(event) {
            const buttonId = event.target.id;
            // probamos si exist este ID producto

            let exists = clickCounts.some(item=> item.m_id_productos === buttonId);

            // Si no exists recordamos
            if (!exists) {

                let productName = getNameProduct(productos, buttonId);
                let productNameCategory = getNameCategory(productos, buttonId);

                let newObject = {
                m_id_productos : buttonId,
                p_nombre: productName,
                p_categoria: productNameCategory,
                m_cantidad_pedida: 1
                };

                clickCounts.push(newObject);

                // Обновление таблицы
                updateTable(newObject, buttonId);

            }
        }


        // Функция для обработки нажатий на кнопки Mas
        function handleButtonClickMas(event) {
            const buttonId = event.target.id;
            // probamos si exist este ID producto

            let exists = clickCounts.some(item=> item.m_id_productos === buttonId);

            // Si no exists recordamos
            if (!exists) {

                let productName = getNameProduct(productos, buttonId);
                let productNameCategory = getNameCategory(productos, buttonId);

                let newObject = {
                m_id_productos : buttonId,
                p_nombre: productName,
                p_categoria: productNameCategory,
                m_cantidad_pedida: 1
                };

                clickCounts.push(newObject);

                // Обновление таблицы
                updateTable(newObject, buttonId);

            }
        }



        // Функция для обновления таблицы
        function updateTable(newObject, buttonId) {
            const tableBody = document.getElementById('factura-nueva');


                // Создание новой строки в таблице
                const newRow = document.createElement('tr');
                newRow.dataset.buttonId = buttonId;
                newRow.innerHTML = `
                    <td>${newObject.p_nombre}</td>
                    <td>${newObject.p_categoria}</td>
                    <td>${newObject.m_cantidad_pedida}</td>
                    <td class="mas" id="${newObject.m_id_productos}">Mas</td>
                    <td class="menos" id="${newObject.m_id_productos}">Menos</td>
                    <td class="borrar" id="${newObject.m_id_productos}">Borrar</td>
                `;
                tableBody.appendChild(newRow);

        }

        // Получение всех кнопок с классом 'anadir' ***
        const buttons = document.querySelectorAll('.anadir');

        // Получение всех кнопок с классом 'mas' ***
        const buttonsMas = document.querySelectorAll('.mas');

        // Получение всех кнопок с классом 'menosr' ***
        const buttonsMenos = document.querySelectorAll('.menos');

        // Получение всех кнопок с классом 'borrar' ***
        const buttonsBorrar = document.querySelectorAll('.borrar');

        // Добавление обработчика событий на каждую кнопку
        buttons.forEach(button => {
            button.addEventListener('click', handleButtonClick);
        });

        buttonsMas.forEach(button => {
            button.addEventListener('click', handleButtonClickMas);
        });

        buttonsMenos.forEach(button => {
            button.addEventListener('click', handleButtonClickMenos);
        });

        buttonsBorrar.forEach(button => {
            button.addEventListener('click', handleButtonClickBorrar);
        });
    });
</script>
