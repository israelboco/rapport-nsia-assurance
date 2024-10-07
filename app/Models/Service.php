<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function agents()
    {
        return $this->hasMany(User::class);
    }
}
