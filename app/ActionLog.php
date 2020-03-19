<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    const ACTION_REQUEST_CREATED =      'создал заявку';
    const ACTION_REQUEST_EDITED =       'изменил заявку';
    const ACTION_REQUEST_SENT =         'отправил заявку на склад';
    const ACTION_REQUEST_PREPARED =     'подготовил заявку';
    const ACTION_REQUEST_SHIPPED =      'отгрузил заявку';
    const ACTION_REQUEST_PAID =         'принял оплату заявку';
    const ACTION_REQUEST_FULLY_PAID =   'полностью закрыл долг по заявке';
    const ACTION_REQUEST_CANCELLED =    'отменил заявку';
    const ACTION_PRICE_LIST_CREATED =   'создал прайс лист';
    const ACTION_PRICE_LIST_EDITED =    'изменил прайс лист';

    /**
     * 
     */
    public static function create($data)
    {
        $log = new ActionLog();
        $log->actor_id = Auth::user()->id;
        $log->text = $data['text'];
        $log->request_id = isset($data['request_id']) ? $data['request_id'] : null;
        $log->price_list_id = isset($data['price_list_id']) ? $data['price_list_id'] : null;
        $log->save();
    }

    /**
     * 
     */
    public static function getLogTextByRequestStatus($status)
    {
        if($status === 'sent')
            return static::ACTION_REQUEST_SENT;

        if($status === 'being_prepared')
            return static::ACTION_REQUEST_PREPARED;

        if($status === 'shipped')
            return static::ACTION_REQUEST_SHIPPED;

        if($status === 'paid')
            return static::ACTION_REQUEST_FULLY_PAID;
    }

    /**
     * 
     */
    public static function getRequestActions($requestId)
    {
        return static::where('request_id', $requestId)
            ->join('users', 'users.id', '=', 'actor_id')
            ->select('users.name as actor_name', 'action_logs.text', 'action_logs.id')
            ->orderBy('action_logs.created_at', 'asc')
            ->get();
    } 
}
