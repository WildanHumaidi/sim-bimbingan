<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KomentarBimbingan extends Model
{
    use HasFactory;

    protected $table = 'komentar_bimbingan';
    protected $primaryKey = 'id_komentar';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_bimbingan',
        'id_pengirim',
        'isi_komentar',
        'tipe_pengirim',
        'waktu_kirim',
        'lampiran_url',
    ];

    protected $casts = [
        'waktu_kirim' => 'datetime',
    ];

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'id_pengirim', 'id_user');
    }

    public function bimbingan()
    {
        return $this->belongsTo(Bimbingan::class, 'id_bimbingan', 'id_bimbingan');
    }
}
