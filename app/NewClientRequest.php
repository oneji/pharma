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

    /**
     * 
     */
    public static function getAll()
    {
        return static::leftJoin('companies', 'companies.id', '=', 'new_client_requests.company_id')
            ->select('new_client_requests.*', 'companies.name as company_name', 'companies.id as company_id')
            ->get();
    }
}
