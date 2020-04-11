<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCompany;
use App\Company;

class CompanyController extends Controller
{
    /**
     * Show all companies
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();

        return view('companies.index', [ 'companies' => $companies ]);
    }

    /**
     * Store a newly created company in the db
     * 
     * @param \Illuminate\Http\Requests\StoreCompany
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompany $request)
    {
        Company::saveCompany($request->name);

        return redirect()->route('companies.index');
    }

    /**
     * Update company
     * 
     * @param int $id
     * @param \Illuminate\Http\Requests\StoreCompany
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, StoreCompany $request)
    {
        Company::updateCompany($id, $request->name);

        return response()->json([
            'ok' => true
        ]);
    }
}
