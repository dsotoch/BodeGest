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
        Schema::create('cancelar_suscripcions', function (Blueprint $table) {
            $table->id();
            $table->boolean("estado")->default(false);
            $table->date('fecha');
            $table->foreignId('suscripcion_id')->references("id")->on("suscripcions")->onDelete("CASCADE");
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
        Schema::dropIfExists('cancelar_suscripcions');
    }
};
