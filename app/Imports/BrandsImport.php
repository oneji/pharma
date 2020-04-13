<?php

namespace App\Imports;

use App\Brand;
use Maatwebsite\Excel\Concerns\ToModel;

class BrandsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Brand([
            'name' => $row['Производитель']
        ]);
    }
}
