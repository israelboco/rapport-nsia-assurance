<?php

namespace App\Exports;

use App\Models\Deal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DealObjectifExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Deal::all();
    }

    public function headings(): array
    {
        return [
            'Code Agent',
            'Prenom',
            'Email',
            'Code_unique',
            'Role_id',
            'Telephone',
            'Domicile',
            'Ifu',
            'Compte bancaire',
            'Service_id',
            'Remove',
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
