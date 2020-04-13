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
}
