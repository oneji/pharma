<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\User;
use App\Role;
use App\Company;
use App\Request as RequestModel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::getAllUsers();
        $roles = Role::all();
        $managers = User::getManagers();
        $companies = Company::all();

        return view('users.index', [ 
            'users' => $users, 
            'roles' => $roles,
            'managers' => $managers,
            'companies' => $companies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        User::createUser([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'phone' => $request->phone,
            'note' => $request->note,
            'discount_amount' => $request->discount_amount,
            'role' => $request->role,
            'responsible_manager_id' => $request->responsible_manager_id,
            'company_id' => $request->company_id
        ]);

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if(!$user) return abort(404);
        
        $roles = Role::all();
        $managers = User::getManagers();
        $companies = Company::all();


        return view('users.edit', [ 
            'user' => $user,
            'roles' => $roles,
            'managers' => $managers,
            'companies' => $companies
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id)
    {
        User::updateUser([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'note' => $request->note,
            'discount_amount' => $request->discount_amount,
            'status' => $request->status,
            'role' => $request->role,
            'responsible_manager_id' => $request->responsible_manager_id,
            'company_id' => $request->company_id
        ], $id);

        return redirect()->route('users.edit', [ 'user' => $id ]);
    }

    /**
     * 
     */
    public function changeStatus($id, $status)
    {
        User::changeStatus($id, $status);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 
     */
    public function debtors()
    {
        $debtors = User::getDebtors();

        // return $debtors;

        return view('users.debtors', [
            'debtors' => $debtors
        ]);
    }
}
