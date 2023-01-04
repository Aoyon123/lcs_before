<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
    use HasFactory;

    protected $table = "experiences";

    public function post(){
        return $this->belongsTo(User::class);
    }
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
