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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_role')->default('3');
            $table->string('nik', 16)->unique();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('telp', 13);
            $table->string('image')->nullable();
            $table->string('api_token')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_role')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
