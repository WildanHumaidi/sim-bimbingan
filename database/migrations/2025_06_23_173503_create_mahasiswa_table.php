<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('id_nim', 20)->primary();
            $table->unsignedInteger('id_user');
            $table->string('nama', 100);
            $table->string('program_studi', 100);
            $table->string('angkatan', 10);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('mahasiswas');
    }
};
