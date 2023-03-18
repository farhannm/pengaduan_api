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
        Schema::create('petugas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_role')->default(2);
            $table->string('nama_petugas');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('telp');
            $table->string('api_token')->nullable();
            $table->timestamps();

            $table->foreign('id_role')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};
