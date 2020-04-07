<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use App\Http\Requests\StoreRole;
use App\Http\Requests\StorePermission;

class AclController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-acl');
    }

    /**
     * Display a listing of the access lists.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('acl.index', [
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     * Set permissions to the roles.
     *
     * @return \Illuminate\Http\Response
     */
    public function setPermissionsToRoles(Request $request)
    {
        foreach ($request->acl as $roleID => $permission) {
            $role = Role::find($roleID);
            $role->permissions()->sync($permission['permissions']);
        }

        return redirect()->route('acl.index');
    }

    /**
     * Set role in the db.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeRole(StoreRole $request)
    {
        Role::store([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        return redirect()->route('acl.index');
    }

    /**
     * Set permission in the db.
     *
     * @return \Illuminate\Http\Response
     */
    public function storePermission(StorePermission $request)
    {
        Permission::store([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        return redirect()->route('acl.index');
    }
}
