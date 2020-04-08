<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\NewClientRequest;
use App\Http\Requests\StoreNewClientRequest;
use Session;

class ClientController extends Controller
{
    /**
     * 
     */
    public function index()
    {
        $newClients = NewClientRequest::getAll();

        return view('new-clients.index', [
            'newClients' => $newClients
        ]);
    }

    /**
     * 
     */
    public function newClient()
    {
        $companies = Company::all();

        return view('new-clients.request', [ 'companies' => $companies ]);
    }

    /**
     * 
     */
    public function saveRequest(StoreNewClientRequest $request)
    {
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'company_id' => $request->company_id
        ];

        NewClientRequest::store($data);

        Session::flash('success', 'Ваша заявка успешно отправлена. ');

        return redirect()->route('newClients.newClient');
    }
}
