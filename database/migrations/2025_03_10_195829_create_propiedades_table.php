<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropiedadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propiedades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('titulo');
            $table->unsignedBigInteger('tipo_propiedad_id');
            $table->foreign('tipo_propiedad_id')->references('id')->on('tipos_propiedades');
            $table->unsignedBigInteger('formato_negocio_id');
            $table->foreign('formato_negocio_id')->references('id')->on('formato_negocios');
            $table->integer('valor_uf');
            $table->integer('cantidad');
            $table->string('tipo_valor');
            $table->integer('valor_pesos');
            $table->unsignedBigInteger('ubicacion_id');
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones');
            $table->integer('m2_superficie');
            $table->integer('m2_construido');
            $table->integer('pisos');
            $table->integer('dormitorios');
            $table->integer('banos');
            $table->unsignedBigInteger('categoria_secundaria_id');
            $table->foreign('categoria_secundaria_id')->references('id')->on('categoria_secundarias');
            $table->text('atributos_adicionales');
            $table->text('descripcion');
            $table->text('direccion');
            $table->text('estado');
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
        Schema::dropIfExists('propiedades');
    }
}
