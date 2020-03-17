<?php

namespace App;

use Auth;
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

    /**
     * Save request payment
     */
    public static function pay($id, $amount)
    {
        $payment = new RequestPayment();
        $payment->amount = $amount;
        $payment->request_id = $id;
        $payment->user_id = Auth::user()->id;
        $payment->save();
    }

    /**
     * 
     */
    public static function setAsPaid($id)
    {
        return $id;
    }
}
