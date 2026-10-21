<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $table = 'program_studi';
    protected $primaryKey = 'id_prodi';

    protected $fillable = [
        'nama_prodi',
        'fakultas',
    ];
    public $timestamps = false;
}
