<?php

namespace App\Imports;

use App\Models\Dango;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DangoImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Dango([
          'dango'=>$row['お団子の種類'],
          'number'=>$row['数'],
          'date'=>$row['購入日']
        ]);
    }
}
