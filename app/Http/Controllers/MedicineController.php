<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMedicine;
use App\Medicine;
use App\Brand;

class MedicineController extends Controller
{
    /**
     * Display a listing of the medicine.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicine = Medicine::getAllMedicineWithBrand();
        $brands = Brand::all();

        return view('medicine.index', [ 
            'medicine' => $medicine,
            'brands' => $brands 
        ]);
    }

    /**
     * Store a newly creaqted medicine in the db
     * 
     * @param \Illuminate\Http\Requests\StoreMedicine
     * 
     * @return \Illuminate\Http\Response 
     */
    public function store(StoreMedicine $request)
    {
        Medicine::saveMedicine([
            'name' => $request->name,
            'brand_id' => $request->brand_id
        ]);

        return redirect()->route('medicine.index');
    }
}
