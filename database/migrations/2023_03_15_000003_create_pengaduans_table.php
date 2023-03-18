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
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->string('nama_pengaduan', 50);
            $table->dateTime('tgl_pengaduan');
            $table->longText('isi_pengaduan')->nullable();
            $table->string('image')->nullable();
            $table->enum('status' ,['Pending', 'Sedang diproses', 'Selesai'])->default('Pending');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
