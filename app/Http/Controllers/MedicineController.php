<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMedicine;
use App\Http\Requests\UpdateMedicine;
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
        $medicine = Medicine::all();
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
            'name' => $request->name
        ]);

        return redirect()->route('medicine.index');
    }

    /**
     * Update medicine item
     * 
     * @param int $id
     * @param \Illuminate\Http\Requests\UpdateMedicine
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateMedicine $request)
    {
        Medicine::updateMedicine($id, [
            'name' => $request->name
        ]);

        return response()->json([
            'ok' => true
        ]);
    }
}
