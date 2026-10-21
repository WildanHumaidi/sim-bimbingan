<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tahun_ajar', function (Blueprint $table) {
            $table->increments('id_tahun');
            $table->string('tahun', 9);
            $table->enum('semester', ['Ganjil', 'Genap']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('tahun_ajar');
    }
};
