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
        Schema::create('suscripcions', function (Blueprint $table) {
            $table->id();
            $table->string('card_id');
            $table->string('suscripcion_id');
            $table->boolean('cancelado_al_finalizar_periodo');
            $table->date('fecha_cargo');
            $table->dateTime('fecha_creacion');
            $table->integer('numero_periodo_actual');
            $table->date('fecha_fin_periodo');
            $table->string('estado');
            $table->date('fecha_fin_prueba');
            $table->string('cantidad_cargo_predeterminada')->nullable();
            $table->string('id_plan');
            $table->string('id_cliente');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('suscripcions');
    }
};
