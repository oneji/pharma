<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
     * 
     */
    public function store(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->save();

        return redirect()->route('brands.index');
    }
}
