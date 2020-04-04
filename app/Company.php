<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * 
     */
    public static function saveCompany($companyName)
    {
        $company = new Company();
        $company->name = $companyName;
        $company->save();
    }
}
