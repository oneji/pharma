<?php

namespace App;

use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Request as RequestModel;

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
        'name', 'username', 'password', 'phone', 'note'
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
    public function requests()
    {
        return $this->hasMany('App\Request');
    }

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
        $user->username = $userData['username'];
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
        $user->username = $userData['username'];
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

    /**
     * 
     */
    /**
     * 
     */
    public static function getDebtors()
    {
        $users = User::whereHas('requests')->with([
            'requests' => function($query) {
                $query
                    ->where('status', '<>', RequestModel::STATUS_CANCELLED)
                    ->with('request_payments');
            }
        ])
        ->leftJoin('companies', 'companies.id', '=', 'users.company_id')
        ->select('users.*', 'companies.name as company_name')
        ->get();

        $debtors = [];
        foreach ($users as $user) {
            if(count($user->requests) > 0) {
                $user->debt_amount = (double) 0;
                $user->paid_amount = (double) 0;
                
                foreach ($user->requests as $req) {
                    $paymentsTotalSum = RequestPayment::getTotalPaymentAmount($req->request_payments);
                    
                    // Determine if the request has debt amount
                    $requestDebtAmount = (double)$req->payment_amount - (double)$paymentsTotalSum;
                    $req->debt_amount = (double)$requestDebtAmount;
                    $user->debt_amount += (double)$requestDebtAmount;
                    $user->paid_amount += (double)$paymentsTotalSum; 
                }

                if($user->debt_amount !== (double)0)
                    $debtors[] = $user;
            }
        }

        return $debtors;
    }

    /**
     * 
     */
    public static function getProfile($id)
    {
        $userProfile = [
            'user' => static::where('id', $id)->first(),
            'paidRequests' => static::getPaidRequests($id)
        ];

        return $userProfile;
    }

    /**
     * 
     */
    public static function getPaidRequests($id)
    {
        return RequestModel::where('user_id', $id)->where('status', '=', 'paid')->get();
    }
}
