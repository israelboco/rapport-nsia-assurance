<?php

namespace App\Exports;

use App\Models\Contrat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ContratsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Contrat::select('produit_code', 
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
        'Typeaffaire')->get();
    }

    public function headings(): array
    {
        return [
            'Code produit', 
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
    }
}
