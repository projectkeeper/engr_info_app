<?php

namespace App\Exports;

use App\Models\Dango;
use Maatwebsite\Excel\Concerns\FromCollection;

class DangoExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Dango::all();
    }
}
