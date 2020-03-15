<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePriceList;
use Illuminate\Support\Facades\DB;
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
        $priceListsCount = DB::table('price_lists')->count();

        if($priceListsCount > 0) {
            $priceListId = DB::table('price_lists')->first()->id;
            $priceList = PriceList::getWithItems($priceListId);

            return view('price_lists.view', [ 'priceList' => $priceList ]);
        } else {
            $medicine = Medicine::all();
            $brands = Brand::all();

            return view('price_lists.create', [
                'medicine' => $medicine,
                'brands' => $brands
            ]);
        }

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

    /**
     * 
     */
    public function edit($id)
    {
        $priceList = PriceList::getWithItems($id);
        $medicine = Medicine::all();
        $brands = Brand::all();

        return view('price_lists.edit', [
            'priceList' => $priceList,
            'medicine' => $medicine,
            'brands' => $brands
        ]);
    }

    /**
     * 
     */
    public function update(Request $request, $id)
    {
        $data = PriceList::change($id, $request->price_list_data);

        return redirect()->route('price_lists.index');
    }
}
