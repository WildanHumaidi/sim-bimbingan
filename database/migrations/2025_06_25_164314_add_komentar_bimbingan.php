<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('komentar_bimbingan', function (Blueprint $table) {
            $table->unsignedInteger('id_komentar')->autoIncrement();
            $table->unsignedInteger('id_bimbingan');
            $table->unsignedInteger('id_pengirim');
            $table->text('isi_komentar');
            $table->timestamp('waktu_kirim')->useCurrent();
            $table->enum('tipe_pengirim', ['dosen', 'mahasiswa']);
            $table->string('lampiran_url', 255)->nullable();

            // Foreign keys
            $table->foreign('id_bimbingan')
                  ->references('id_bimbingan')
                  ->on('bimbingan')
                  ->onDelete('cascade');

            $table->foreign('id_pengirim')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');

            $table->index('id_bimbingan');
            $table->index('id_pengirim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('komentar_bimbingan');
    }
};
