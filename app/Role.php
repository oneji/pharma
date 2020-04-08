<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    /**
     * Store the role to db
     * 
     * @param array $data
     */
    public static function store($data)
    {
        $role = new Role();
        $role->name = $data['name'];
        $role->display_name = $data['display_name'];
        $role->description = $data['description'];
        $role->save();
    }

    /**
     * Get all the roles except "superadministrator"
     * 
     * @param string $exceptionRole
     * 
     * @return object
     */
    public static function getExcept($exceptionRole)
    {
        return static::where('name', '<>', $exceptionRole)->get();
    }
}
