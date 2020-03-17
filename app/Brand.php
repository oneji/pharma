<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
     * The medicine that belong to the brand.
     */
    public function medicines()
    {
        return $this->belongsToMany('App\Medicine');
    }

    /**
     * 
     */
    public static function saveBrand($brandName)
    {
        $brand = new Brand();
        $brand->name = $brandName;
        $brand->save();
    }
}
