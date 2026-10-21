<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\FakController;

class Dosen extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_nidn';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_nidn',
        'id_user',
        'nama',
        'jabatan',
        'fakultas',
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'nidn', 'id_nidn');
    }

    // Method untuk validasi fakultas
    public static function validateFakultas($fakultas)
    {
        return in_array($fakultas, config('fakultas.list', []));
    }

    // Method untuk mendapatkan daftar fakultas
    public static function getListFakultas()
    {
        return config('fakultas.list', []);
    }

    // Scope untuk filter by fakultas
    public function scopeByFakultas($query, $fakultas)
    {
        return $query->where('fakultas', $fakultas);
    }

    // Accessor untuk memformat nama fakultas
    public function getFakultasAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    // Mutator untuk menyimpan fakultas
    public function setFakultasAttribute($value)
    {
        $this->attributes['fakultas'] = ucwords(strtolower($value));
    }

    // Method untuk dosen berdasarkan fakultas
    public static function getDosenByFakultas($fakultas)
    {
        if (!self::validateFakultas($fakultas)) {
            return collect(); // Return empty collection jika fakultas tidak valid
        }

        return self::where('fakultas', $fakultas)->get();
    }
}
