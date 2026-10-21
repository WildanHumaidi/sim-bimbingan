<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->string('nidn_pembimbing', 20)->nullable()->after('angkatan');
            $table->string('judul_skripsi', 255)->nullable()->after('nidn_pembimbing');
            $table->enum('status_sidang', ['belum_acc', 'acc_sidang'])->default('belum_acc')->after('judul_skripsi');
            $table->timestamp('tanggal_acc_sidang')->nullable()->after('status_sidang');
            $table->text('catatan_acc_sidang')->nullable()->after('tanggal_acc_sidang');

            $table->foreign('nidn_pembimbing')->references('id_nidn')->on('dosens')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropForeign(['nidn_pembimbing']);
            $table->dropColumn([
                'nidn_pembimbing',
                'judul_skripsi',
                'status_sidang',
                'tanggal_acc_sidang',
                'catatan_acc_sidang',
            ]);
        });
    }
};
