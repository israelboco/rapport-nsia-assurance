<?php

namespace App\Exports;

use App\Models\Deal;
use App\Models\Role;
use App\Models\Service;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DealExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user = Auth::user();

        if($user->is_admin){ 
            $agent_ids = User::where('remove', false)
                ->pluck('id');
            
        }else{
            $subordinate_ids = Supervisor::where('supervisor_id', $user->id)->pluck('user_id');
            $agent_ids = User::whereIn('id', $subordinate_ids)
                            ->where('remove', false)
                            ->pluck('id');
        }

        $deals = Deal::where('remove', false)->whereIn('user_id', $agent_ids)->select('nature', 'montant',
        'prospect_nom', 'prospect_prenom',
        'prospect_telephone', 'prospect_email',
        'lieu_signature', 'statut', 'date_conclusion')->get();

        return $deals;
    }

    public function headings(): array
    {
        return [
            'Nature', 'Montant',
        'Prospect Nom', 'Prospect Prenom',
        'Prospect Telephone', 'Prospect Email',
        'Lieu signature', 'Statut', 'Date conclusion'
        ];
    }
}
