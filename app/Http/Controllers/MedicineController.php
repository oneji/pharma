<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
     * 
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'brand_id' => 'required|exists:brands,id'
        ]);

        Medicine::saveMedicine($validatedData);

        return redirect()->route('medicine.index');
    }
}
