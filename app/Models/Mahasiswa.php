<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_nim',
        'id_user',
        'nama',
        'program_studi',
        'angkatan',
        'nidn_pembimbing',
        'judul_skripsi',
        'status_sidang',
        'tanggal_acc_sidang',
        'catatan_acc_sidang',
    ];

    protected $casts = [
        'tanggal_acc_sidang' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function dosenPembimbing()
    {
        return $this->belongsTo(Dosen::class, 'nidn_pembimbing', 'id_nidn');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'nim', 'id_nim');
    }

    public function bimbinganValid()
    {
        return $this->hasMany(Bimbingan::class, 'nim', 'id_nim')->where('status_validasi', 'valid');
    }

    public function isSiapSidang(): bool
    {
        return $this->status_sidang === 'acc_sidang';
    }
}
