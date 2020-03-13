<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePriceList;
use App\PriceList;
use App\Medicine;
use App\Brand;
use Carbon\Carbon;


class PriceListController extends Controller
{
    /**
     * 
     */
    public function index()
    {
        $priceLists = PriceList::getAll();
        $medicine = Medicine::all();
        $brands = Brand::all();

        return view('price_lists.index', [ 
            'priceLists' => $priceLists,
            'medicine' => $medicine,
            'brands' => $brands
        ]);
    }

    /**
     * 
     */
    public function view($id)
    {
        $priceList = PriceList::getWithItems($id);

        // return $priceList;

        return view('price_lists.view', [ 'priceList' => $priceList ]);
    }

    /**
     * 
     */
    public function create()
    {
        $priceLists = PriceList::getAll();
        $medicine = Medicine::all();
        $brands = Brand::all();

        return view('price_lists.create', [ 
            'priceLists' => $priceLists,
            'medicine' => $medicine,
            'brands' => $brands
        ]);
    }

    /**
     * 
     */
    public function createPriceList(Request $request)
    {
        $priceList = PriceList::create($request->price_list_data);

        return redirect()->route('price_lists.view', [ 'id' => $priceList->id ]);
    }
}
