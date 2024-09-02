<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaFacturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('factura_id');                             // Уникальный идентификатор фактуры
            $table->unsignedBigInteger('f_id_cliente');      // Идентификатор пользователя-продавца
            $table->boolean('f_tipo');                      // tipo 0-entrada 1-salida
            $table->decimal('f_suma', 10, 2) ->value(0);               // Сумма фактуры отправленной
            $table->unsignedBigInteger('f_id_responsable') ->nullable();    // Идентификатор пользователя-приемщика
            $table->date('f_fecha_tramitacion') ->nullable();              // Дата фактуры приема
            $table->decimal('f_suma_tramitacion', 10, 2)->value(0);    // Сумма фактуры принятой
            $table->boolean('f_aceptado')->default(false);                  // Флаг принятия заказа (true или false)
            $table->timestamps();                            // Поля created_at и updated_at

            // Определение внешних ключей
            $table->foreign('f_id_cliente')
                  ->references('Usuario_id')
                  ->on('usuarios')
                  ->onDelete('cascade');

            $table->foreign('f_id_responsable')
                  ->references('usuario_id')
                  ->on('usuarios')
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
