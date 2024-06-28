<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario')->nullable(false);
            $table->string('nombre')->nullable(false);
            $table->string('RFC')->nullable(false);
            $table->json('informacion_adicional')->nullable();
            $table->json('contacto')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('estatus')->default(1);
            $table->timestamps();


            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
