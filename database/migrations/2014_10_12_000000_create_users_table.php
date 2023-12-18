<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 8)->unique(); // Campo adicional
            $table->string('nombres')->nullable(); // Campo adicional
            $table->string('apellidos')->nullable(); // Campo adicional
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('nombreUsuario')->nullable(); // Campo adicional
            $table->string('rol')->nullable(); // Campo adicional
            $table->foreignId('perteneceA')->nullable(); // Campo adicional
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
