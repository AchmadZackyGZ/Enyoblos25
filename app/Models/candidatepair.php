<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class candidatepair extends Model
{
    use HasFactory;

    protected $fillable = [
        'chairman',
        'vicechairman',
        'vision',
        'mission',
        'photo',
        'score'
    ];

    public function getDataChairman()
    {
        return $this->belongsTo(Candidate::class, 'chairman', 'id');
    }

    public function getDataViceChairman()
    {
        return $this->belongsTo(Candidate::class, 'vicechairman', 'id');
    }

}
