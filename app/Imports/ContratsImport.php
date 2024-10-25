<?php

namespace App\Imports;

use App\Models\Contrat;
use App\Models\Produit;
use Maatwebsite\Excel\Concerns\ToModel;

class ContratsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (empty($row[0]) || !is_numeric(($row[0]))) {
            return null; 
        }
        
        $produit = Produit::where('code_unique', $row[0])->first();
        return new Contrat([
            'produit_id' => isset($produit) ? $produit->id: null,
            'produit_code' => $row[0],
            'Police' => $row[1],
            'N_Quittance' => $row[2],
            'N_Quittance_Annulee' => $row[3],
            'Prime_Pure' => $row[4],
            'Charges_Gestion' => $row[5],
            'Ccial_externe' => $row[6],
            'Frais_acquisition' => $row[7],
            'Frais_de_fractionnement' => $row[8],
            'Droit_entree' => $row[9],
            'Cout_Piece' => $row[10],
            'Prime_Nette' => $row[11],
            'Solde' => $row[12],
            'Montant_a_payer' => $row[13],
            'inenc' => $row[14],
            'Impayes' => $row[15],
            'Encaissements' => $row[16],
            'Production_brute_exo' => $row[17],
            'Date_Comptable' => $row[18],
            'Date_debut_Quittance' => $row[19],
            'Date_Fin_Quittance' => $row[20],
            'Date_Effet_Police' => $row[21],
            'Date_Fin_effet_Police' => $row[22],
            'Date_Resiliation' => $row[23],
            'Periodicite' => $row[24],
            'Fractionnement' => $row[25],
            'N_Assure' => $row[26],
            'N_Payeur' => $row[27],
            'Point_de_vente' => $row[28],
            'convention' => $row[29],
            'Date_Creation' => $row[30],
            'Date_Creation_QCO' => $row[31],
            'Date_Annulation_QCO' => $row[32],
            'Mois_Effet_Quittance' => $row[33],
            'N_Police' => $row[34],
            'N_Client' => $row[35],
            'Date_Naissance' => $row[36],
            'Adresse' => $row[37],
            'Contact1' => $row[38],
            'Contact2' => $row[39],
            'Nom_et_Prenoms_Assure' => $row[40],
            'NPoint_de_vente' => $row[41],
            'Nom_Point_de_vente' => $row[42],
            'jaagenp_quaag' => $row[43],
            'jaagenp_winag' => $row[44],
            'jaagenp_winit' => $row[45],
            'Typeapporteur' => $row[46],
            'Branche' => $row[47],
            'Reseau' => $row[48],
            'Typeaffaire' => $row[49]
        ]);
    }
}
