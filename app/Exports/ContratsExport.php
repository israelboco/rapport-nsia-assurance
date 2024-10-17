<?php

namespace App\Exports;

use App\Models\Contrat;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContratsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Contrat::all();
    }
}
