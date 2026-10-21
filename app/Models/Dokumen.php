<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Dokumen extends Model
{
    use HasFactory;
    protected $table = 'dokumen';

    protected $primaryKey = 'id_dokumen';

    protected $fillable = [
        'id_bimbingan',
        'nama_file',
        'file_path',
        'uploaded_at',
    ];

    public $timestamps = false;

    public function bimbingan()
    {
        return $this->belongsTo(Bimbingan::class, 'id_bimbingan', 'id_bimbingan');
    }

    /**
     * Get user-friendly file name
     */
    public function getDisplayNameAttribute()
    {
        // Remove timestamp or hash from filename if needed
        return preg_replace('/-\d+\.pdf$/', '.pdf', $this->nama_file);
    }

    /**
     * Get full public URL to the document
     */
    public function getPublicUrlAttribute()
    {
        if (str_starts_with($this->file_path, 'doc/')) {
            return asset($this->file_path);
        }
        return asset('storage/' . ltrim($this->file_path, '/'));
    }

    /**
     * Check if file exists in storage
     */
    public function fileExists()
    {
        if (file_exists(public_path($this->file_path))) {
            return true;
        }
        return Storage::disk('public')->exists($this->file_path);
    }
}
