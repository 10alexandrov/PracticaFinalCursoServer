<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token for Laravel -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
                            <td> <a class="anadir" id="{{$producto->product_id}}" href='#'>Anadir </a></td>
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
                            <th> Menus </th>
                            <th> Borrar </th>
                        </tr>
                    </thead>
                    <tbody id="factura-nueva">
                        <tr id="factura-nueva"></tr>
                    </tbody>
                </table>
            </div>


            <a  href="#">
                <button class='m-100' id="crearFactura">Crear nuevo pedido </button>
           </a>

           <a  href="#">
            <button class='m-100' id="borrarFactura">Borrar pedido </button>
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
        let clickCounts;
        const clickCountsLocalStorage = localStorage.getItem('facturaNueva');

        if (clickCountsLocalStorage) {
            clickCounts = JSON.parse(clickCountsLocalStorage);
        } else {
            clickCounts = [];
        }

        updateTable(clickCounts);  // devoler datos a la tabla Factura

                // Get name product by ID
        function getNameProduct (productos, buttonId) {

            const producto = productos.find(p=>p.product_id == buttonId);
            return producto ? producto.p_nombre : "sin nombre";
        }
        // get category product by ID
        function getNameCategory (productos, buttonId) {
            const producto = productos.find(p=>p.product_id == buttonId);
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
                updateTable(clickCounts);

            }
        }


        // Функция для обработки нажатий на кнопки Mas
        function handleButtonClickMas(event) {
            const buttonId = event.target.id;
            console.log ('mas');
            console.log(buttonId);

            if (Array.isArray(clickCounts)) {
                clickCounts.forEach(correctObject => {
                    if (correctObject.m_id_productos == buttonId) {
                        correctObject.m_cantidad_pedida = (correctObject.m_cantidad_pedida || 0) + 1;
                    }
                });

                // Обновление таблицы
                updateTable(clickCounts);

            }
        }

                // Функция для обработки нажатий на кнопки Menos
            function handleButtonClickMenos(event) {
            const buttonId = event.target.id;

            if (Array.isArray(clickCounts)) {
                clickCounts.forEach(correctObject => {
                    if (correctObject.m_id_productos == buttonId) {
                        correctObject.m_cantidad_pedida = (correctObject.m_cantidad_pedida || 0) - 1;
                    }
                });

                // Обновление таблицы
                updateTable(clickCounts);

            }
        }

        // Функция для обработки нажатий на кнопки Borrar
        function handleButtonClickBorrar(event) {
            console.log('flagB');
            const buttonId = event.target.id;
            const index = clickCounts.findIndex(n=>n.m_id_productos == buttonId);
            if (index !== -1) {
                clickCounts.splice(index,1);
            }

        // Обновление таблицы
        updateTable(clickCounts);

        }

        // function para update listeners de actiones

        function updateButtons () {

            // Получение всех кнопок с классом 'mas' ***
            const buttonsMas = document.querySelectorAll('.mas');

            // Получение всех кнопок с классом 'menosr' ***
            const buttonsMenos = document.querySelectorAll('.menos');

            // Получение всех кнопок с классом 'borrar' ***
            const buttonsBorrar = document.querySelectorAll('.borrar');

            buttonsMas.forEach(button1 => {
                button1.removeEventListener('click', handleButtonClickMas);
            });

            buttonsMenos.forEach(button2 => {
                button2.removeEventListener('click', handleButtonClickMenos);
            });

            buttonsBorrar.forEach(button3 => {
                button3.removeEventListener('click', handleButtonClickBorrar);
            });

            buttonsMas.forEach(button1 => {
                button1.addEventListener('click', handleButtonClickMas);
            });

            buttonsMenos.forEach(button2 => {
                button2.addEventListener('click', handleButtonClickMenos);
            });

            buttonsBorrar.forEach(button3 => {
                button3.addEventListener('click', handleButtonClickBorrar);
            });



        }



        // Функция для обновления таблицы
        function updateTable(newObject) {

            localStorage.setItem('facturaNueva', JSON.stringify(clickCounts))
            const tableBody = document.getElementById('factura-nueva');
            tableBody.innerHTML ='';


                // Создание новой строки в таблице
                if (Array.isArray(clickCounts)) {
                    clickCounts.forEach(newObject => {
                        const newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <td>${newObject.p_nombre}</td>
                            <td>${newObject.p_categoria}</td>
                            <td>${newObject.m_cantidad_pedida}</td>
                            <td class="mas"> <button id="${newObject.m_id_productos}">Mas</button></td>
                            <td class="menos"> <button id="${newObject.m_id_productos}">Menos</button></td>
                            <td class="borrar"> <button id="${newObject.m_id_productos}">Borrar</button></td>
                        `;
                        tableBody.appendChild(newRow);
                    });
                }

            updateButtons();

        }

        // Получение всех кнопок с классом 'anadir' ***
        const buttons = document.querySelectorAll('.anadir');

        // Получение button Borrar totalmente
        const buttonBorrar = document.getElementById('borrarFactura');

        // Получение button Crear Factura
        const buttonCrear = document.getElementById('crearFactura');

        console.log(clickCounts);

        // Добавление обработчика событий на каждую Anadir
        buttons.forEach(button => {
            button.addEventListener('click', handleButtonClick);
        });

        // Добавление обработчика событий на Borrar Factura
        buttonBorrar.addEventListener('click', () => {
            console.log('flag');
            clickCounts = [];
            localStorage.removeItem('clickCounts');
            updateTable(clickCounts);
        });

        // Добавление обработчика событий на Borrar Factura
        buttonCrear.addEventListener('click', () => {

            console.log(JSON.stringify({ products: clickCounts }));

            fetch('/pedido/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ products: clickCounts })
            })
            .then(response => {
                if (!response.ok) {
                    // Выводим код статуса и текст ответа для отладки
                    return response.text().then(text => {
                        throw new Error(`Network response was not ok. Status: ${response.status}. Response: ${text}`);
                    });
                }

                return response.json();
            })
            .then(data => {
                console.log('Data sent successfully:', data);
                clickCounts = [];
                localStorage.removeItem('clickCounts');
                updateTable(clickCounts);
            })
            .catch(error => {
                console.error('Error sending data:', error);
            });
        });
    });
</script>
