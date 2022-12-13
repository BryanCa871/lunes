<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',30);
            $table->string('edificio',30);
            $table->string('ubicacion',30);
            $table->unsignedbigInteger('sensor_id'); 
            $table->foreign('sensor_id')->references('id')->on('sensores');
            $table->unsignedbigInteger('usuario_id'); 
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->enum('status',["inactivo","activo"]);
            
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
        Schema::dropIfExists('salones');
    }
};
