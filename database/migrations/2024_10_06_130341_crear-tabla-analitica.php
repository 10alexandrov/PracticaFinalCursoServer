<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAnalitica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadisticas', function (Blueprint $table) {
            $table->id();
            $table->date('e_fecha')->default(DB::raw('CURRENT_DATE'));
            $table->decimal('e_suma_restos', 10, 2);
            $table->integer('e_volumen_restos')->default(0);
            $table->decimal('e_suma_compras_hoy', 10, 2);
            $table->decimal('e_suma_ventas_hoy', 10, 2);
            $table->decimal('e_suma_compras_mes', 10, 2);
            $table->decimal('e_suma_ventas_mes', 10, 2);
            $table->decimal('e_beneficios_hoy', 10, 2);
            $table->decimal('e_beneficios_mes', 10, 2);

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
