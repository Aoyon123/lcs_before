<?php

namespace App\Models;

use App\Models\Experience;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function experiances()
    {
        return $this->hasMany(Experience::class);
    }
    public function academics()
    {
        return $this->hasMany(AcademicQualification::class);
    }
}
