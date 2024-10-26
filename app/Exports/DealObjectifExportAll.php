<?php

namespace App\Exports;

use App\Models\Deal;
use App\Models\Role;
use App\Models\Service;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DealObjectifExportAll implements FromCollection, WithHeadings
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user_id = Auth::user()->id;
        $dealsObjectif = collect();
        $list_users = [];

        $objectif_nb_contrats_jour = 60 * 3/ 5;
        $objectif_ca_jour = ($objectif_nb_contrats_jour * 10000 + 5000000) / 12 / 4 / 5 * 60;

        $objectif_nb_contrats_semaine = $objectif_nb_contrats_jour * 5;
        $objectif_ca_semaine = $objectif_ca_jour * 5;

        $objectif_nb_contrats_mois = $objectif_nb_contrats_jour * 5 * 4;
        $objectif_ca_mois = $objectif_ca_jour * 5 * 4;

        $objectif_nb_contrats_annee = $objectif_nb_contrats_jour * 5 * 4 * 12;
        $objectif_ca_annee = $objectif_ca_jour * 5 * 4 * 12;

        $list_users = User::all()->pluck('id')->toArray();
        foreach($list_users as $user_id){
            $user = User::find($user_id);
            if (!$user) continue;

            $user_deal = [
                'code_unique' => $user->code_unique,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'domicile' => $user->domicile ?? 'N/A',
                'service' => Service::find($user->service_id)->nom ?? 'N/A',
                'role' => Role::find($user->role_id)->nom ?? 'N/A'
            ];


            $ca_jour = Deal::where('user_id', $user_id)
                        ->where('remove', false)
                        ->where('statut', 'à conclure')
                        ->whereDate('date_conclusion', '>=', Carbon::today())
                        ->sum('montant');
            $nb_contrats_jour = Deal::where('user_id', $user_id)
                        ->where('remove', false)
                        ->where('statut', 'à conclure')
                        ->whereDate('date_conclusion', '>=', Carbon::today())
                        ->count();
            $user_deal['ca_jour'] = $ca_jour ?? 0;
            $user_deal['nc_jour'] = $nb_contrats_jour ?? 0;
            $user_deal['obj_ca_jour'] = $objectif_ca_jour;
            $user_deal['obj_nc_jour'] = $objectif_nb_contrats_jour;
            if($ca_jour >= $objectif_ca_jour && $nb_contrats_jour >= $objectif_nb_contrats_jour){
                $user_deal['decission_jour'] = 'Félicitation objectif atteint';
            }else{
                $user_deal['decission_jour'] = 'Attention';
            }

            $ca_semaine = Deal::where('user_id', $user_id)
                        ->where('remove', false)
                        ->where('statut', 'à conclure')
                        ->whereDate('date_conclusion', '>=', Carbon::now()->startOfWeek())
                        ->sum('montant');
            
            $nb_contrats_semaine = Deal::where('user_id', $user_id)
                        ->where('remove', false)
                        ->where('statut', 'à conclure')
                        ->whereDate('date_conclusion', '>=', Carbon::now()->startOfWeek())
                        ->count();

            $user_deal['ca_semaine'] = $ca_semaine ?? 0;
            $user_deal['nc_semaine'] = $nb_contrats_semaine ?? 0;
            $user_deal['obj_ca_semaine'] = $objectif_ca_semaine;
            $user_deal['obj_nc_semaine'] = $objectif_nb_contrats_semaine;
            if($ca_semaine >= $objectif_ca_semaine && $nb_contrats_semaine >= $objectif_nb_contrats_semaine){
                $user_deal['decission_semaine'] = 'Félicitation objectif atteint';
            }else{
                $user_deal['decission_semaine'] = 'Attention';
            }

            $ca_mois = Deal::where('user_id', $user_id)
                        ->where('remove', false)
                        ->where('statut', 'à conclure')
                        ->whereDate('date_conclusion', '>=', Carbon::now()->startOfMonth())
                        ->sum('montant');

            $nb_contrats_mois = Deal::where('user_id', $user_id)
                        ->where('remove', false)
                        ->where('statut', 'à conclure')
                        ->whereDate('date_conclusion', '>=', Carbon::now()->startOfMonth())
                        ->count();

            $user_deal['ca_mois'] = $ca_mois ?? 0;
            $user_deal['nc_mois'] = $nb_contrats_mois ?? 0;
            $user_deal['obj_ca_mois'] = $objectif_ca_mois;
            $user_deal['obj_nc_mois'] = $objectif_nb_contrats_mois;
            if($ca_mois >= $objectif_ca_mois && $nb_contrats_mois >= $objectif_nb_contrats_mois){
                $user_deal['decission_mois'] = 'Félicitation objectif atteint';
            }else{
                $user_deal['decission_mois'] = 'Attention';
            }

            $ca_annee = Deal::where('user_id', $user_id)
                        ->where('remove', false)
                        ->where('statut', 'à conclure')
                        ->whereDate('date_conclusion', '>=', Carbon::now()->startOfYear())
                        ->sum('montant');

            $nb_contrats_annee = Deal::where('user_id', $user_id)
                ->where('remove', false)
                ->where('statut', 'à conclure')
                ->whereDate('date_conclusion', '>=', Carbon::now()->startOfYear())
                ->count();

            $user_deal['ca_annee'] = $ca_annee ?? 0;
            $user_deal['nc_annee'] = $nb_contrats_annee ?? 0;
            $user_deal['obj_ca_annee'] = $objectif_ca_annee;
            $user_deal['obj_nc_annee'] = $objectif_nb_contrats_annee;
            if($ca_annee >= $objectif_ca_annee && $nb_contrats_annee >= $objectif_nb_contrats_annee){
                $user_deal['decission_annee'] = 'Félicitation objectif atteint';
            }else{
                $user_deal['decission_annee'] = 'Attention';
            }

            $dealsObjectif->push($user_deal);
        }

        return $dealsObjectif;
    }

    public function headings(): array
    {
        return [
            'Code Agent',
            'Nom',
            'Prenom',
            'Domicile',
            'Service',
            'Role',
            'CA Jour',
            'Nbr Contrat Jour',
            'Objectif CA Jour',
            'Objectif Nbr Contrat Jour',
            'Decission',
            'CA Semaine',
            'Nbr Contrat Semaine',
            'Objectif CA Semaine',
            'Objectif Nbr Contrat Semaine',
            'Decission',
            'CA Mois',
            'Nbr Contrat Mois',
            'Objectif CA Mois',
            'Objectif Nbr Contrat Mois',
            'Decission',
            'CA Année',
            'Nbr Contrat Année',
            'Objectif CA Année',
            'Objectif Nbr Contrat Année',
            'Decission',
        ];
    }
}
