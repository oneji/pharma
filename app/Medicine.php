<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    /**
     * The brand that belong to the medicine.
     */
    public function brands()
    {
        return $this->belongsToMany('App\Brand');
    }

    /**
     * Save medicine
     */
    public static function saveMedicine($medicineData)
    {
        $medicine = new Medicine();
        $medicine->name = $medicineData['name'];
        $medicine->save();
        
        $medicine->brands()->attach($medicineData['brand_id']);
    }

    /**
     * 
     */
    public static function getAllMedicineWithBrand()
    {
        return DB::table('brand_medicine')
            ->join('medicines', 'medicines.id', '=', 'brand_medicine.medicine_id')
            ->join('brands', 'brands.id', '=', 'brand_medicine.brand_id')
            ->select('brand_medicine.*', 'medicines.name as medicine_name', 'brands.name as brand_name')
            ->get();
    }
}
