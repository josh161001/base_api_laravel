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
        Schema::create('refacciones', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('id_categoria')->nullable();
            $table->unsignedBigInteger('id_marca')->nullable();
            $table->unsignedBigInteger('id_clave_sat')->nullable();
            $table->unsignedBigInteger('id_linea')->nullable();
            $table->string('modelo')->unique()->nullable()->default(null);
            $table->integer('cantidad')->nullable()->default(null);
            $table->string('sku')->nullable()->default(null);
            $table->text('informacion')->nullable()->default(null);
            $table->string('descripcion')->nullable()->default(null);
            $table->text('herramientas')->nullable()->default(null);
            $table->text('sintomas_fallas')->nullable()->default(null);
            $table->text('intercambios')->nullable()->default(null);
            $table->json('models')->nullable()->default(null);
            $table->text('position')->nullable()->default(null);
            $table->boolean('estatus')->nullable()->default(0);

            $table->foreign('id_categoria')->references('id')->on('categorias')->onDelete('cascade');
            $table->foreign('id_marca')->references('id')->on('marcas')->onDelete('cascade');
            $table->foreign('id_clave_sat')->references('id')->on('claves_sat')->onDelete('cascade');
            $table->foreign('id_linea')->references('id')->on('lineas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refacciones');
    }
};
