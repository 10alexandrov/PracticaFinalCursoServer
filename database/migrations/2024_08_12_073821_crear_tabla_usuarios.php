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
            $table->id('usuario_id');                          // Уникальный идентификатор п
            $table->string('u_nombre', 255);                   // Название продукта
            $table->string('u_login',100)->unique();
            $table->string('u_password', 60);
            $table->enum('u_role',['admin','manager','cliente','vendedor','receptor','recogedor']);  // Role usuario
            $table->boolean('u_active');    // Usuario ative
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
