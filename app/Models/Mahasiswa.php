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
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'nim', 'id_nim');
    }
}
