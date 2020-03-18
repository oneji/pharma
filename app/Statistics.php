<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Request as RequestModel;
use App\RequestPayment;

class Statistics extends Model
{
    public static function getFull()
    {
        $usersCount = User::all()->count();
        $requestsCount = RequestModel::all()->count();
        $medicineCount = Medicine::all()->count();
        $brandsCount = Brand::all()->count();

        return [
            'usersCount' => $usersCount,
            'requestsCount' => $requestsCount,
            'medicineCount' => $medicineCount,
            'brandsCount' => $brandsCount
        ];
    }
}
