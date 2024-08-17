<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaMercancias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mercancias', function (Blueprint $table) {
            $table->unsignedBigInteger('m_id_facturas');               // Идентификатор фактуры, связан с таблицей facturas_recogida
            $table->unsignedBigInteger('m_id_productos');              // Идентификатор продукта, связан с таблицей productos
            $table->integer('m_cantidad_pedida');                      // Количество заказанного товара
            $table->integer('m_cantidad_recogida');                    // Количество принятого товара
            $table->decimal('m_suma_pedida', 10, 2);                   // Сумма за заказанный товар
            $table->decimal('m_suma_recogida', 10, 2);                 // Сумма за принятый товар
            $table->boolean('m_aceptado');                             // Флаг принятия (true или false)
            $table->date('m_fecha_pedida');                            // Дата заказа товара
            $table->date('m_fecha_recogida');                          // Дата сбора товара

            // Уникальный составной ключ на основе пары pr_id_facturas и pr_id_productos
            $table->primary(['m_id_facturas', 'm_id_productos']);

            // Связь с таблицей facturas_recogida
            $table->foreign('m_id_facturas')
                  ->references('f_id')
                  ->on('facturas')
                  ->onDelete('cascade');

            // Связь с таблицей productos
            $table->foreign('m_id_productos')
                  ->references('id_product')
                  ->on('productos')
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
