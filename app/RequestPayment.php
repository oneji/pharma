<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestPayment extends Model
{
    /**
     * Get the request that owns the payment.
     */
    public function request()
    {
        return $this->belongsTo('App\Request');
    }
}
