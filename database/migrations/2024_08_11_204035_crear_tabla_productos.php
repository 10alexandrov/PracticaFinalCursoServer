<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('product_id');                          // Уникальный идентификатор продукта
            $table->string('p_nombre', 255);                   // Название продукта
            $table->unsignedBigInteger('p_categoria');             // Categoria
            $table->string('p_descripcion', 255)->nullable();  // Описание продукта (может быть пустым)
            $table->integer('p_ancho');                          // Ширина продукта
            $table->integer('p_longitud');                      // Длина продукта
            $table->integer('p_altura');                        // Высота продукта
            $table->integer('p_peso');                        // Вес продукта
            $table->string('p_foto', 255)->nullable();         // Ссылка на фото продукта (может быть пустой)
            $table->integer('p_cantidad_almacen');             // Количество продукта на складе
            $table->integer('p_cantidad_entrega');             // Количество продукта в пути
            $table->integer('p_cantidad_reservado');           // Количество продукта зарезервировано
            $table->integer('p_cantidad_enviado');             // Количество продукта отправленного
            $table->decimal('p_precio_compra', 10, 2);         // Цена закупки
            $table->decimal('p_precio_venta', 10, 2);          // Цена продажи
            $table->string('p_codigo', 255)            ;         // Codigo de barras
            $table->timestamps();                              // Добавляет столбцы created_at и updated_at

                        // Определение внешних ключей
                        $table->foreign('p_categoria')
                        ->references('id_categoria')
                        ->on('categorias')
                        ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
