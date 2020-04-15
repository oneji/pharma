<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBrand;
use App\Brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the brands.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();

        return view('brands.index', [ 'brands' => $brands ]);
    }

    /**
     * Store a newly created brand in the db
     * 
     * @param \Illuminate\Http\Requests\StoreBrand
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrand $request)
    {
        Brand::saveBrand($request->name);

        return redirect()->route('brands.index');
    }

    /**
     * Update existing brand
     * 
     * @param \Illuminate\Http\Requests\StoreBrand
     * 
     * @return \Illuminate\Http\Response
     */
    public function update($id, StoreBrand $request)
    {
        Brand::updateBrand($id, $request->name);

        return response()->json([
            'ok' => true,
        ]);
    }


    /**
     * 
     */
    public function getAllBrandsAjax(Request $request)
    {
        return response()->json(Brand::getForSelect($request->q));
    }
}
