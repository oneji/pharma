<?php

namespace App;

use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'note'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 
     */
    public static function getAllUsers()
    {
        return static::where('id', '<>', Auth::user()->id)->get();
    }
    /**
     * 
     */
    public static function createUser($userData)
    {
        $user = new User();
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->password = Hash::make($userData['password']);
        $user->phone = $userData['phone'];
        $user->note = $userData['note'];
        $user->save();

        // Attach role the user
        if(isset($userData['role'])) {
            $user->roles()->attach($userData['role']);
        }
    }

    /**
     * 
     */
    public static function updateUser($userData, $id)
    {
        $user = User::find($id);
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->phone = $userData['phone'];
        $user->note = $userData['note'];
        $user->status = $userData['status'];
        $user->save();

        // Detach the user's roles
        $user->roles()->detach($user->roles);

        // Change user's role
        if(isset($userData['role'])) {
            $user->roles()->attach($userData['role']);
        }
    }
}
