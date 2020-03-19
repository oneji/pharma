<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-users');
    }

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

        return view('users.index', [ 
            'users' => $users, 
            'roles' => $roles,
            'managers' => $managers
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
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'note' => $request->note,
            'discount_amount' => $request->discount_amount,
            'role' => $request->role,
            'responsible_manager_id' => $request->responsible_manager_id
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
        $roles = Role::all();
        $managers = User::getManagers();

        if(!$user) return abort(404);

        return view('users.edit', [ 
            'user' => $user,
            'roles' => $roles,
            'managers' => $managers
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
            'email' => $request->email,
            'phone' => $request->phone,
            'note' => $request->note,
            'discount_amount' => $request->discount_amount,
            'status' => $request->status,
            'role' => $request->role,
            'responsible_manager_id' => $request->responsible_manager_id
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
}
