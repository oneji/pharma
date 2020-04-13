<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statistics;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BrandsImport;
use App\Brand;
use App\Medicine;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stats = Statistics::getFull();

        return view('home', [ 'stats' => $stats ]);
    }

    /**
     * 
     */
    public function importExcel()
    {
        return view('excel');
    }

    /**
     * 
     */
    public function import(Request $request)
    {
        if($request->hasFile('excel_file')) {
            $items = Excel::toArray(new BrandsImport, $request->file('excel_file'));
            
            $brands = [];
            $medicine = [];


            for($j = 0; $j < count($items[0]); $j++) {
                if($items[0][$j][1] !== null) {
                    $brands[] = [
                        'name' => $items[0][$j][1]
                    ];
                }

                if($items[0][$j][0] !== null) {
                    $medicine[] = [
                        'name' => $items[0][$j][0]
                    ];
                }
            }

            $medicineUnique = collect($medicine)->unique()->values()->all();
            $brandsUnique = collect($brands)->unique()->values()->all();

            Brand::insert($brandsUnique);
            Medicine::insert($medicineUnique);

            return [
                'ok' => true
            ];
        } else {
            return [
                'ok' => false
            ];
        }
    }
}
