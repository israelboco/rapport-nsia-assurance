<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'produit_id', 'nature', 'montant',
        'prospect_nom', 'prospect_prenom',
        'prospect_telephone', 'prospect_email',
        'lieu_signature', 'statut', 'date_conclusion'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

}
