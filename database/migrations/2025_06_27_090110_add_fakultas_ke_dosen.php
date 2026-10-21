<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('dosens', function (Blueprint $table) {
            $table->string('fakultas', 100)->after('jabatan');
        });
    }

    public function down(): void {
        Schema::table('dosens', function (Blueprint $table) {
            $table->dropColumn('fakultas');
        });
    }
};
