<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bimbingan', function (Blueprint $table) {
            $table->increments('id_bimbingan');
            $table->string('nim', 20);
            $table->string('nidn', 20);
            $table->date('tanggal');
            $table->text('topik');
            $table->text('catatan')->nullable();
            $table->enum('status_validasi', ['pending', 'valid', 'invalid'])->default('pending');
            $table->string('dokumen_url', 255)->nullable();
            $table->timestamps();

            $table->foreign('nim')->references('id_nim')->on('mahasiswas')->onDelete('cascade');
            $table->foreign('nidn')->references('id_nidn')->on('dosens')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('bimbingan');
    }
};
