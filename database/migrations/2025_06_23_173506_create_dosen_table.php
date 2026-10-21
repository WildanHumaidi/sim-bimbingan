<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dosens', function (Blueprint $table) {
            $table->string('id_nidn', 20)->primary();
            $table->unsignedInteger('id_user');
            $table->string('nama', 100);
            $table->string('jabatan', 50);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('dosens');
    }
};
