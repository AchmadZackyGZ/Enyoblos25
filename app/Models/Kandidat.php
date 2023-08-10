<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'nomor_wa',
        'visi',
        'misi',
        'foto',
        'pdf_ktm',
        'suket_organisasi',
        'suket_lkmm_td',
        'transkrip_nilai',
        'skor_fpt',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
