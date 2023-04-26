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
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->string('marca');
            $table->string('presentacion');
            $table->string('stock');
            $table->string('precioCompra');
            $table->string('precioVenta');
            $table->string('medida');
            $table->string('lucro');

            $table->foreignId('id_provedor')->nullable()->references('id')->on('provedores')->onDelete(NULL);
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete(NULL);

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
        Schema::dropIfExists('articulos');
    }
};
