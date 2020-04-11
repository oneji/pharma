<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Role;
use App\User;
use App\NewClientRequest;
use App\Http\Requests\StoreNewClientRequest;
use App\Http\Requests\StoreNewClient;
use Session;

class ClientController extends Controller
{
    /**
     * Show all new client requests
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newClients = NewClientRequest::getAll();
        $companies = Company::all();
        $roles = Role::all();
        $managers = User::getManagers();

        return view('new-clients.index', [
            'newClients' => $newClients,
            'companies' => $companies,
            'roles' => $roles,
            'managers' => $managers
        ]);
    }

    /**
     * Show new client page
     * 
     * @return \Illuminate\Http\Response
     */
    public function newClient()
    {
        $companies = Company::all();

        return view('new-clients.request', [ 'companies' => $companies ]);
    }

    /**
     * Store a newly creatde new client request in the db
     * 
     * @param \Illuminate\Http\Requests\StoreNewClientRequest
     * 
     * @return \Illuminate\Http\Response
     */
    public function saveRequest(StoreNewClientRequest $request)
    {
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'address' => $request->address
        ];

        NewClientRequest::store($data);

        Session::flash('success', 'Ваша заявка успешно отправлена. ');

        return redirect()->route('newClients.newClient');
    }

    /**
     * Store a newly created client account in the db
     * 
     * @param \Illuminate\Http\Requests\StoreNewClient $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewClient $request)
    {
        NewClientRequest::storeNewClient([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'phone' => $request->phone,
            'note' => $request->note,
            'discount_amount' => $request->discount_amount,
            'role' => $request->role,
            'responsible_manager_id' => $request->responsible_manager_id,
            'company_id' => $request->company_id,
            'request_number' => $request->request_number
        ]);

        return redirect()->route('newClients.index');
    }
}
