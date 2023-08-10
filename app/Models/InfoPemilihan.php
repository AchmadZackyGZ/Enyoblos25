<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoPemilihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tahun',
        'status_pemilihan',
        'status_pendaftaran'
    ];
}
