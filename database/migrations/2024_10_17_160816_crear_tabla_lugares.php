<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaLugares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lugares', function (Blueprint $table) {
            $table->id();
            $table->char('lugar_estanteria', 1);
            $table->integer('lugar_column');
            $table->integer('lugar_planta');
            $table->integer('lugar_producto');
            $table->integer('lugar_cantidad') ->default(0);
            $table->decimal('lugar_llenado', 10, 1) ->default(0);
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
