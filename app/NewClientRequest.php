<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewClientRequest extends Model
{
    /**
     * 
     */
    public static function store($data)
    {
        $newClientRequest = new NewClientRequest();
        $newClientRequest->name = $data['name']; 
        $newClientRequest->phone = $data['phone']; 
        $newClientRequest->company_id = $data['company_id'];
        $newClientRequest->save();

        return $newClientRequest;
    }
}
