<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bimbingan extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_VALID = 'valid';
    const STATUS_INVALID = 'invalid';

    protected $table = 'bimbingan';
    protected $primaryKey = 'id_bimbingan';

    protected $fillable = [
        'nim',
        'nidn',
        'tanggal',
        'topik',
        'catatan',
        'status_validasi',
        'dokumen_url',
        'dibaca_oleh_dosen',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'dibaca_oleh_dosen' => 'datetime',
    ];

    public function setStatusValidasiAttribute($value)
    {
        $this->attributes['status_validasi'] = strtolower((string) $value);
    }


    /**
     * Relationship to Mahasiswa
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'id_nim');
    }

    /**
     * Relationship to Dosen
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'id_nidn');
    }

    /**
     * Relationship to Dokumen
     */
    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'id_bimbingan', 'id_bimbingan');
    }

    /**
     * Relationship to KomentarBimbingan
     */
    public function komentar(): HasMany
    {
        return $this->hasMany(KomentarBimbingan::class, 'id_bimbingan', 'id_bimbingan')
            ->orderBy('waktu_kirim', 'desc');
    }

    /**
     * Scope for bimbingan yang valid
     */
    public function scopeValid($query)
    {
        return $query->where('status_validasi', self::STATUS_VALID);
    }

    /**
     * Scope for bimbingan yang pending
     */
    public function scopePending($query)
    {
        return $query->where('status_validasi', self::STATUS_PENDING);
    }

    /**
     * Scope for bimbingan yang invalid
     */
    public function scopeInvalid($query)
    {
        return $query->where('status_validasi', self::STATUS_INVALID);
    }
}
