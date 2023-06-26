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
        Schema::create('saldos', function (Blueprint $table) {
            $table->id();
            $table->string("monto_deuda");
            $table->string("monto_recibido");
            $table->string("monto_restante");
            $table->date("fecha");
            $table->string("estado");
            $table->foreignId("user_id")->nullable()->references("id")->on('users')->onDelete('cascade');
            $table->foreignId("cliente_id")->nullable()->references("id")->on('clientes')->onDelete('set null');
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
        Schema::dropIfExists('saldos');
    }
};
