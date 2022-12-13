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
        Schema::create('sensores', function (Blueprint $table) {
            $table->id();
            $table->set('tipo_sensor',["temperatura","luz","corriente","magnetismo","movimiento","humo"]);
            $table->unsignedBigInteger('dato')->default(0);
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
        Schema::dropIfExists('sensores');
    }
};
