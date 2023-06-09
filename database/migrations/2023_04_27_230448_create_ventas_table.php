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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('documento');
            $table->date('fecha');
            $table->string('iva');
            $table->string('nota');
            $table->string('formaPago');
            $table->string('montoInicio');
            $table->string('totalVenta');
            $table->string('moneda');
            $table->foreignId('cliente_id')->nullable()->references('id')->on('clientes')->onDelete(NULL);
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('ventas');
    }
};
