<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sms;

class SmsController extends Controller
{
    /**
     * 
     */
    public function send()
    {
        return Sms::send([
            'phone_number' => '992007070144',
            'request_number' => 123
        ], Sms::SMS_REQUEST_CREATED);
    }
}
