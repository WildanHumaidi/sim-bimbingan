<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bimbingan', function (Blueprint $table) {
            $table->timestamp('dibaca_oleh_dosen')->nullable()->after('status_validasi');
        });
    }

    public function down(): void
    {
        Schema::table('bimbingan', function (Blueprint $table) {
            $table->dropColumn('dibaca_oleh_dosen');
        });
    }
};
