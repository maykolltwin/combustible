<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('unidads', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 4)->nullable()->default(null);
            $table->string('descripcion')->nullable()->default(null);
            $table->string('abreviatura', 50)->unique();
            $table->timestamps();
        });

        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('primer_nombre', 50);
            $table->string('segundo_nombre', 50)->nullable()->default(null);
            $table->string('primer_apellido', 50);
            $table->string('segundo_apellido', 50);
            $table->string('expediente', 6)->nullable()->default(null);
            $table->string('carne', 11)->unique();
            $table->timestamps();
        });

        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('matricula', 7)->unique();
            $table->string('descripcion')->nullable()->default(null);
            $table->foreignId('persona_id')->nullable()->constrained()->default(null);
            $table->timestamps();
        });

        Schema::create('vehiculo_asignados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained();
            $table->foreignId('vehiculo_id')->unique()->constrained();
            $table->timestamps();
        });

        Schema::create('tarjetas', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 16)->unique();
            $table->unsignedDouble('saldo')->default(0);
            $table->string('descripcion')->nullable()->default(null);
            // $table->foreignId('persona_id')->nullable()->constrained();
            // $table->foreignId('vehiculo_id')->nullable()->constrained();
            // $table->foreignId('unidad_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehiculo_asignados');
        Schema::dropIfExists('vehiculos');
        Schema::dropIfExists('personas');

        Schema::dropIfExists('unidads');
        
        
        Schema::dropIfExists('tarjetas');
    }
};
