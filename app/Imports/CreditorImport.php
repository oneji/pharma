<?php

namespace App\Imports;

use App\Creditor;
use Maatwebsite\Excel\Concerns\ToModel;


class CreditorImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Creditor([
            'user_id' => $row[0],
            'bill_number' => $row[1],
            'amount' => $row[2],
            'date' => $row[3]
        ]);
    }
}
