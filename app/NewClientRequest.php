<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        $newClientRequest->company_id = $data['company_id'];
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
        return static::leftJoin('companies', 'companies.id', '=', 'new_client_requests.company_id')
            ->select('new_client_requests.*', 'companies.name as company_name', 'companies.id as company_id')
            ->get();
    }
}
