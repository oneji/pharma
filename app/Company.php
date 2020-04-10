<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * Save company in the db
     * 
     * @param string $companyName
     */
    public static function saveCompany($companyName)
    {
        $company = new Company();
        $company->name = $companyName;
        $company->save();
    }
}
