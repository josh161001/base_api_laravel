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
            $table->foreignId('id_categoria')->nullable()->constrained('categorias')->onDelete('cascade');
            $table->foreignId('id_marca')->nullable()->constrained('marcas')->onDelete('cascade');
            $table->foreignId('id_clave_sat')->nullable()->constrained('claves_sat')->onDelete('cascade');
            $table->foreignId('id_linea')->nullable()->constrained('lineas')->onDelete('cascade');

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
