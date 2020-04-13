<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    /**
     * The medicine that belong to the brand.
     */
    public function medicines()
    {
        return $this->belongsToMany('App\Medicine');
    }

    /**
     * Save brand in the db
     * 
     * @param string $brandName
     */
    public static function saveBrand($brandName)
    {
        $brand = new Brand();
        $brand->name = $brandName;
        $brand->save();
    }

    /**
     * Update brand
     * 
     * @param int $id
     * @param string $brandName
     */
    public static function updateBrand($id, $brandName)
    {
        $brand = static::find($id);
        $brand->name = $brandName;
        $brand->save();
    }
}
