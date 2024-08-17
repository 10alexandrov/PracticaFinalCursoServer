<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');                          // Уникальный идентификатор п
            $table->string('u_nombre', 255);                   // Название продукта
            $table->string('u_login',100)->unique();
            $table->string('u_password', 255);
            $table->enum('u_role',['admin','manager','cliente','vendedor','receptor','recogedor']);  // Role usuario
            $table->timestamps();
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
