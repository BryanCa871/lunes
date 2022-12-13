<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('sensores', function (Blueprint $table) {
            //
            
        });

        DB::table("sensores")
        ->insert([
            "tipo_sensor"=>"luz",
            "status"=>"activo",
        ]);

        DB::table("sensores")
        ->insert([
            "tipo_sensor"=>"temperatura",
            "status"=>"activo",
        ]);

        DB::table("sensores")
        ->insert([
            "tipo_sensor"=>"humo",
            "status"=>"activo",
        ]);

        DB::table("sensores")
        ->insert([
            "tipo_sensor"=>"corriente",
            "status"=>"activo",
        ]);

        DB::table("sensores")
        ->insert([
            "tipo_sensor"=>"magnetismo",
            "status"=>"activo",
        ]);

        DB::table("sensores")
        ->insert([
            "tipo_sensor"=>"movimiento",
            "status"=>"activo",
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sensores', function (Blueprint $table) {
            //
        });
    }
};
