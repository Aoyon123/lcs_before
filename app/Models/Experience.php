<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $fillable = [
        'Institute_name',
        'designation',
        'department',
        'start_date',
        'end_date',
        'current_working',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
