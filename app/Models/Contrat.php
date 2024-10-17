<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'produit_id', 
        'produit_code', 
        'Police',
        'N_Quittance',
        'N_Quittance_Annulee',
        'Prime_Pure',
        'Charges_Gestion',
        'Ccial_externe',
        'Frais_acquisition',
        'Frais_de_fractionnement',
        'Droit_entree',
        'Cout_Piece',
        'Prime_Nette',
        'Solde',
        'Montant_a_payer',
        'inenc',
        'Impayes',
        'Encaissements',
        'Production_brute_exo',
        'Date_Comptable',
        'Date_debut_Quittance',
        'Date_Fin_Quittance',
        'Date_Effet_Police',
        'Date_Fin_effet_Police',
        'Date_Resiliation',
        'Periodicite',
        'Fractionnement',
        'N_Assure',
        'N_Payeur',
        'Point_de_vente',
        'convention',
        'Date_Creation',
        'Date_Creation_QCO',
        'Date_Annulation_QCO',
        'Mois_Effet_Quittance',
        'N_Police',
        'N_Client',
        'Date_Naissance',
        'Adresse',
        'Contact1',
        'Contact2',
        'Nom_et_Prenoms_Assure',
        'NPoint_de_vente',
        'Nom_Point_de_vente',
        'jaagenp_quaag',
        'jaagenp_winag',
        'jaagenp_winit',
        'Typeapporteur',
        'Branche',
        'Reseau',
        'Typeaffaire'
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
