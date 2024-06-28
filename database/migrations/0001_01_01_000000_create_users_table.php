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

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique()->nullable(false);
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_padre')->nullable()->default(null);
            $table->unsignedBigInteger('id_rol')->nullable(false)->default('1');
            $table->string('nombre_completo')->nullable(false);
            $table->string('correo')->unique()->nullable(false);
            $table->timestamp('correo_verified_at')->nullable();
            $table->string('contrasena')->nullable(false);
            $table->string('movil')->unique()->nullable();
            $table->boolean('estatus')->default(0);
            $table->rememberToken();

            $table->foreign('id_padre')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_rol')->references('id')->on('roles')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('roles');
    }
};
