<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('program_studi', function (Blueprint $table) {
            $table->increments('id_prodi');
            $table->string('nama_prodi', 100);
            $table->string('fakultas', 100);
        });
    }

    public function down(): void {
        Schema::dropIfExists('program_studi');
    }
};
