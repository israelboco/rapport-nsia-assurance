<?php

namespace App\Exports;

use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user = Auth::user();
        $agents = User::select('nom', 'prenom', 'email', 'code_unique',
        'role_id', 'telephone', 'domicile', 'ifu',
        'compte_bancaire', 'service_id', 'sexe', 'mode_reglement', 'date_naissance',
        'lieu_naissance', 'fixe', 'banque', 'date_collaboration')->get();

        if(!$user->is_admin){
            $subordinate_ids = Supervisor::where('supervisor_id', $user->id)->pluck('user_id');
            $service_id = $user->service->id;
            $agents = User::whereIn('id', $subordinate_ids)
                ->when($service_id, function ($query) use ($service_id) {
                    return $query->where('service_id', $service_id);
                })
                ->orderByDesc('id')->select('nom', 'prenom', 'email', 'code_unique',
                'role_id', 'telephone', 'domicile', 'ifu',
                'compte_bancaire', 'service_id', 'sexe', 'mode_reglement', 'date_naissance',
                'lieu_naissance', 'fixe', 'banque', 'date_collaboration')->get();;
        }

        return $agents;
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Prenom',
            'Email',
            'Code_unique',
            'Role_id',
            'Telephone',
            'Domicile',
            'Ifu',
            'Compte bancaire',
            'Service_id',
            'Sexe',
            'Mode reglement',
            'Date naissance',
            'Lieu naissance',
            'Fixe',
            'Banque',
            'Date collaboration',
        ];
    }
}
