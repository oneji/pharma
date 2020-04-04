<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCompany;
use App\Company;

class CompanyController extends Controller
{
    /**
     * 
     */
    public function index()
    {
        $companies = Company::all();

        return view('companies.index', [ 'companies' => $companies ]);
    }

    /**
     * 
     */
    public function store(StoreCompany $request)
    {
        Company::saveCompany($request->name);

        return redirect()->route('companies.index');
    }
}
