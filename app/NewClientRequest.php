<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sms;
use Illuminate\Support\Facades\Hash;

class NewClientRequest extends Model
{
    /**
     * Store a newly created client request in the db
     * 
     * @param array $data
     * 
     * @return collection $newClientRequest
     */
    public static function store($data)
    {
        $newClientRequest = new NewClientRequest();
        $newClientRequest->name = $data['name']; 
        $newClientRequest->phone = $data['phone']; 
        $newClientRequest->company_name = $data['company_name'];
        $newClientRequest->address = $data['address'];
        $newClientRequest->save();

        return $newClientRequest;
    }

    /**
     * Get all new client requests
     * 
     * @return collection
     */
    public static function getAll()
    {
        return static::all();
    }

    /**
     * Store a newly created client account in the db
     * 
     * @param array $data
     * 
     * @return collection
     */
    public static function storeNewClient($data) {
        $user = new User();
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->password = Hash::make($data['password']);
        $user->phone = $data['phone'];
        $user->note = $data['note'];
        $user->discount_amount = $data['discount_amount'];
        $user->responsible_manager_id = $data['responsible_manager_id'];
        $user->company_id = $data['company_id'];
        $user->save();

        // Attach role the user
        if(isset($data['role'])) {
            $user->roles()->attach($data['role']);
        }

        Sms::send([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => $data['password'],
            'phone_number' => $data['phone']
        ], Sms::SMS_CLIENT_CREATED);
    }
}
