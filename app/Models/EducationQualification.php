<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationQualification extends Model
{
    use HasFactory;
    protected $fillable = [
        'qualification_name',
        'subject',
        'passing_year',
        'result',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
