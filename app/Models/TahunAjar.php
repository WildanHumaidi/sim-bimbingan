<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjar extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajar';
    protected $primaryKey = 'id_tahun';

    protected $fillable = [
        'tahun',
        'semester',
    ];

    public $timestamps = false;
}
