<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'code_unique', 'description'];

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
}
