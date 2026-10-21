<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'foto',
        'status_verifikasi',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'role' => 'integer',
    ];

    public $timestamps = true;

    public function getAvatarUrlAttribute(): string
    {
        if (!$this->foto) {
            return asset('img/default-avatar.png');
        }

        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            return $this->foto;
        }

        if (str_starts_with($this->foto, 'profile/')) {
            return asset($this->foto);
        }

        return match ((int)$this->role) {
            1 => asset('profile/admin/' . $this->foto),
            2 => asset('profile/dosen/' . $this->foto),
            3 => asset('profile/mhs/' . $this->foto),
            default => asset('img/default-avatar.png'),
        };
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'id_user', 'id_user');
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'id_user', 'id_user');
    }
}
