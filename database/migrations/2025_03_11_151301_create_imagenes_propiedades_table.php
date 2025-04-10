<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagenesPropiedadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagenes_propiedades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('propiedad_id');
            $table->foreign('propiedad_id')->references('id')->on('propiedades');
            $table->integer('principal');
            $table->integer('posicion');
            $table->string('ruta_imagen')->nullable();
            $table->integer('estado');
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
        Schema::dropIfExists('imagenes_propiedades');
    }
}
