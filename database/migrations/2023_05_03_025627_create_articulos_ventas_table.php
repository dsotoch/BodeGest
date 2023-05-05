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
        Schema::create('articulos_ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ventas_id')->nullable()->references('id')->on('ventas')->onDelete('set null');
            $table->foreignId('articulos_id')->nullable()->references('id')->on('articulos')->onDelete('set null');
            $table->string('cantidad');
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
        Schema::dropIfExists('articulos_ventas');
    }
};
