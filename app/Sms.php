<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Sms extends Model
{
    // Sms config
    const SMS_LOGIN =       'sifatpharma';
    const SMS_HASH =        '62efddaf4d0285c92ccfa3bcf7045b95';
    const SMS_SENDER =      'SifatPharma';
    const SMS_SERVER =      'http://api.osonsms.com/sendsms_v1.php';
    const SMS_SYSTEM_URL =  'wwww.pharma.digital.tj';

    // Sms text messages
    const SMS_REQUEST_CREATED = 'smsRequestCreated';
    const SMS_CLIENT_CREATED = 'smsClientCreated';

    /**
     * Send sms to the user's phone number
     * 
     * @param array $params
     */
    public static function send($data, $smsType)
    {
        $login = static::SMS_LOGIN;
        $from = static::SMS_SENDER;
        $smsApi = static::SMS_SERVER;
        $pass_salt_hash = static::SMS_HASH;
        $phone_number = $data['phone_number'];
        $msg = static::createMessage($data, $smsType);
        $txn_id = uniqid();
        $dlmr = ';';
        $str_hash = hash('sha256', $txn_id.$dlmr.$login.$dlmr.$from.$dlmr.$phone_number.$dlmr.$pass_salt_hash);

        // Create a client with a base URI
        $client = new \GuzzleHttp\Client();
        // API params
        $params = [
            'query' => [
                'from' => $from,
                'phone_number' => $phone_number,
                'msg' => $msg,
                'login' => $login,
                'str_hash' => $str_hash,
                'txn_id' => $txn_id
            ]
        ];
        
        $response = $client->get(static::SMS_SERVER, $params);

        return $response->getBody();
    }

    /**
     * 
     */
    public static function createMessage($data, $smsType)
    {
        $msg = '';
        if($smsType === static::SMS_REQUEST_CREATED) {
            $msg =  "Вы создали заявку на сайте " . static::SMS_SYSTEM_URL . "\n" . 
                    "Номер заявки: " . $data['request_number'];
        } else if($smsType === static::SMS_CLIENT_CREATED) {
            $msg =  $data['name'] . " вы были зарегистрированы как пользователь системы " . static::SMS_SYSTEM_URL . "\n" .
                    "Ваш логин: " . $data['username'] . "\n" .
                    "Ваш пароль: " . $data['password'];
        }

        return $msg;
    }
}
