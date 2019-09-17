<?php

namespace App\Exports;

use App\Credito;
use Maatwebsite\Excel\Concerns\FromCollection;

class CreditoExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Credito::all();
    }
}
