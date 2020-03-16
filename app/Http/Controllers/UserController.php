<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangeUserPassword;
use App\User;
use App\Role;

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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'phone' => 'nullable',
            'note' => 'nullable',
            'role' => 'required',
            'responsible_manager_id' => 'nullable'
        ]);

        User::createUser($validatedData);

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
    public function update(Request $request, $id)
    {
        // return $request;
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'nullable',
            'note' => 'nullable',
            'status' => 'integer|in:1,0',
            'role' => 'required',
            'responsible_manager_id' => 'nullable'
        ]);

        User::updateUser($validatedData, $id);

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
    public function editPassword()
    {
        return view('auth.passwords.change');
    }

    /**
     * 
     */
    public function changePassword(ChangeUserPassword $request)
    {
        $result = User::updatePassword($request->old_password, $request->password);

        if(!$result['ok']) {
            return redirect()->route('password.edit')->withErrors([
                'passwordError' => $result['message']
            ]);
        }

        return redirect()->route('password.edit');
    }
}
