<?php

namespace App\Imports;

use App\Models\Contrat;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class ContratsImport implements ToModel
{

    protected $lookupData;
    protected $feuil6;
    protected $repartitionFvi;

    public function __construct(array $lookupData, array $feuil6, array $repartitionFvi)
    {
        $this->lookupData = $lookupData;
        $this->feuil6 = $feuil6;
        $this->repartitionFvi = $repartitionFvi;
    }

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

        $agent = User::where('code', $row[28])->first();
        
        $produit = Produit::where('code_unique', $row[0])->first();
        
        return new Contrat([
            'user_id' => isset($agent) ? $agent->id: null,
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
            // 'Periodicite' => $periodicite($row),
            // 'Fractionnement' => $fractionnement($row),
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
            'Typeaffaire' => $row[49],
            'Periodicite' => $this->getPeriodicite($row),
            'Fractionnement' => $this->getFractionnement($row),
            'Promesse' => $this->getPromesse($row),
            'MoisCreation' => $this->getMoisCreation($row),
            'AffaireNouvelle' => $this->getAffaireNouvelle($row),
            'ComEncadrement' => $this->getComEncadrement($row),
            'semaine' => Carbon::parse($row['AE5'])->isoWeek,
            'nomProduit' => $this->getRule($row['A6']),
            'Mode' => $this->getMode($row['B2']),
            'annee' => Carbon::now()->year,
            'affaireNouvelleReel' => $this->getAffaireNouvelleReel($row),
            'Banque' => $this->getBanque($row['AZ2']),
            'ChefCG' => $this->getChefCg($row['AP4']),
            'ChefInspecteur' => $this->getChefInspecteur($row['AP3']),
            'ChefEquipe' => $this->getChefEquipe($row['AP2']),
            'CaService' => $this->getCaService($row),

        ]);
    }

    protected function getFractionnement(array $row)
    {
        if (in_array($row['AD3'], [1000837, 1000847])) {
            return 'U';
        }
        return $this->lookupData[$row['B3']] ?? 0;
    }

    protected function getPeriodicite($row) {
        return $this->lookupData[$row['B5']] ?? 0;
    }

    protected function getPromesse($row) {
        if (in_array($row['A2'], [6120, 2300])) {
            return $row['N2'];
        }
        if ($row['A2'] == 6150 && $row['Y2'] === 'U') {
            return $row['N2'];
        }
        return 0;
    }

    protected function getMoisCreation($row) {
        $year = (int)date('Y', strtotime($row['AE3']));
        $month = (int)date('m', strtotime($row['AE3']));
    
        return $year < 2024 ? 1 : $month;
    }

    protected function getAffaireNouvelle($row) {
        $yearV4 = (int)date('Y', strtotime($row['V4']));
        $monthV4 = (int)date('m', strtotime($row['V4']));
        $yearT4 = (int)date('Y', strtotime($row['T4']));
        $monthT4 = (int)date('m', strtotime($row['T4']));
    
        if ($row['A4'] == 6150 && $row['L4'] == 5000) {
            return 0;
        }
    
        if ($yearV4 == 2024 && $monthV4 == $monthT4 && $yearT4 == 2024) {
            return $row['L4'] / abs($row['L4']);
        }
    
        return 0;
    }

    protected function getComEncadrement($row) {
        if ($row['BO3'] === 'U' || $row['A3'] == 6120 || $row['A3'] == 2300) {
            return $row['Q3'];
        }
    
        return 0;
    }

    protected function getMode($row) {
        return $this->feuil6[$row][6] ?? null;
    }

    protected function getAffaireNouvelleReel($row) {
        $annee = Carbon::now()->year;
        if ($annee === 2024) {
            return 'affaires nouvelles';
        } elseif (in_array($row['A4'], [6120, 2300])) {
            return 'Affaires nouvelles';
        } else {
            return 'Renouvellement';
        }
    }

    protected function getBanque($row) {
        $az2 = $row['AZ2'] ?? null;
        return match ($az2) {
            'E' => 'Especes',
            'C' => 'Chèque',
            'L' => 'MoMo',
            default => 'Banque/Trésor',
        };
    }

    protected function getChefCg($row) {
        return $this->repartitionFvi[$row['AP4']][22] ?? $row['AU4'];
    }

    protected function getChefInspecteur($row) {
        return $this->repartitionFvi[$row['AP3']][21] ?? $row['AU3'];
    }

    protected function getChefEquipe($row) {
        return $this->repartitionFvi[$row['AP2']][20] ?? $row['AU2'];
    }

    protected function getCaService($row) {
        if ($row['AU2'] === 'BUREAU DIRECT' && in_array($row['A2'], [5200, 6200, 6100, 5300])) {
            return 'BUREAU DIRECT CORPORATE';
        }
        if ($row['AU2'] === 'BUREAU DIRECT' && $row['AB2'] == 100095) {
            return 'BUREAU DIRECT CORPORATE';
        }
        if ($row['AC2'] == 111) {
            return 'BUREAU DIRECT CORPORATE';
        }
        return $row['AU2'] ?? null;
    }

    protected function getRule($code) {
        if (in_array($code, [1160, 1165, 1640, 1660, 1680])) return 'Prevoyance IND';
        if (in_array($code, [2160, 2180])) return 'NSIA Retraite';
        if (in_array($code, [2400, 2410, 2420, 2430, 2460])) return 'NSIA Pension Classique';
        if (in_array($code, [3100, 3120])) return 'NSIA Etudes';
        if (in_array($code, [5100, 5120, 5140, 5160])) return 'NSIA Emprunteur Entreprise';
        if (in_array($code, [5300, 5330])) return 'NAF Entreprise';
        if (in_array($code, [7400, 7420])) return 'NSIA Solde bancaire';
        if (in_array($code, [7520, 7550, 7580])) return 'NSIA Emprunteur bancaire';
    
        // Add additional checks or fallback
        return match ($code) {
            6150 => 'NSIA Fortune',
            1120 => 'NSIA Emprunteur IND',
            2300 => 'NSIA Libre Retraite',
            2600 => 'NSIA Epargne Projet',
            3330 => 'NAF Classique',
            3620 => 'NSIA Vitalis',
            5200 => 'NSIA PDG',
            6100 => 'CAREC Entreprise',
            6120 => 'CAREC IND',
            6200 => 'NSIA IFC',
            7620 => 'NSIA Epargne SIKA',
            7960 => 'Etudes personnel NSIA',
            default => 'Unknown',
        };
    }
    
}
