<?php

namespace App;

use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Support\Facades\Hash;
use Session;

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
        return static::where('users.id', '<>', Auth::user()->id)
            ->leftJoin('companies', 'users.company_id', '=', 'companies.id')
            ->select('users.*', 'companies.name as company_name')
            ->get();
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
        $user->discount_amount = $userData['discount_amount'];
        $user->responsible_manager_id = $userData['responsible_manager_id'];
        $user->company_id = $userData['company_id'];
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
        $user->discount_amount = $userData['discount_amount'];
        $user->status = $userData['status'];
        $user->responsible_manager_id = $userData['responsible_manager_id'];
        $user->company_id = $userData['company_id'];
        $user->save();

        // Detach the user's roles
        $user->roles()->detach($user->roles);

        // Change user's role
        if(isset($userData['role'])) {
            $user->roles()->attach($userData['role']);
        }
    }

    /**
     * 
     */
    public static function changeStatus($id, $status)
    {
        $user = static::find($id);
        $user->status = $status;
        $user->save(); 
    }

    /**
     * 
     */
    public static function updatePassword($oldPassword, $newPassword)
    {
        $user = static::find(Auth::user()->id);

        if (Hash::check($oldPassword, $user->password)) {
            $user->password = Hash::make($newPassword);
            $user->password_changed = 1;
            $user->save();

            Session::flash('password.success', 'Пароль успешно изменен.');
            return [ 'ok' => true ];
        } else {
            return [
                'ok' => false,
                'message' => 'Старый пароль не совпадает.'
            ];
        }
    }

    public static function isPasswordChanged()
    {
        return Auth::user()->password_changed === 0 ? false : true;
    }

    /**
     * 
     */
    public static function getManagers()
    {
        return Role::with('users')->where('name', 'manager')->first()->users;
    }
}
