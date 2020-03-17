<?php

namespace App;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    /**
     * Store the permission to db
     * 
     * @param array $data
     */
    public static function store($data)
    {
        $permission = new Permission();
        $permission->name = $data['name'];
        $permission->display_name = $data['display_name'];
        $permission->description = $data['description'];
        $permission->save();
    }
}
