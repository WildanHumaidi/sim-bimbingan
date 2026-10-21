<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->increments('id_dokumen');
            $table->unsignedInteger('id_bimbingan');
            $table->string('nama_file', 255);
            $table->string('file_path', 255);
            $table->timestamp('uploaded_at')->useCurrent();

            $table->foreign('id_bimbingan')->references('id_bimbingan')->on('bimbingan')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('dokumen');
    }
};
