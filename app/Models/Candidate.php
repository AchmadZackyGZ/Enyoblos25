<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'photo',
        'student_card',
        'organization_letter',
        'lkmtd_letter',
        'transcript', 
        'status', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getWithUser(){
      return self::with('user')->get();
    }

    public function findWithUser($id){
        return self::with('user')->find($id);
      }


}
