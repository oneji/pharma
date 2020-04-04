<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use App\ActionLog;

class Request extends Model
{
    // Request statuses
    const STATUS_UNDER_REVISION = 'under_revision';
    const STATUS_SENT = 'sent';
    const STATUS_WRITTEN_OUT = 'written_out';
    const STATUS_BEING_PREPARED = 'being_prepared';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';

    // Request priorities
    const PRIORITY_HIGH = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_LOW = 3;

    /**
     * Get the payments for the request.
     */
    public function request_payments()
    {
        return $this->hasMany('App\RequestPayment');
    }

    /**
     * Get the items for the request.
     */
    public function request_items()
    {
        return $this->hasMany('App\RequestItem');
    }
    
    /**
     * 
     */
    public static function getAll()
    {
        $user = Auth::user();
        $userRole = $user->roles()->first()->name;

        if($userRole === 'head_manager' || $userRole === 'superadministrator') {
            return static::join('users', 'users.id', '=', 'requests.user_id')
                ->select('users.name as username', 'requests.*')
                ->get();
        }

        if($userRole === 'manager') {
            $underUsers = User::where('responsible_manager_id', $user->id)->pluck('id');

            return static::whereIn('user_id', $underUsers)
                ->orWhere('user_id', $user->id)
                ->join('users', 'users.id', '=', 'requests.user_id')
                ->select('users.name as username', 'requests.*')
                ->get();
        } 
        
        if($userRole === 'logist' || $userRole === 'director' || $userRole === 'cashier') {
            return static::join('users', 'users.id', '=', 'requests.user_id')
                ->select('users.name as username', 'requests.*')
                ->get();
        }

        return static::where('user_id', $user->id)
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('users.name as username', 'requests.*')
            ->get();
    }

    /**
     * 
     */
    public static function setPaymentAmount($items, $data)
    {
        $paymentAmount = 0; 
        $plItems = PriceListItem::whereIn('id', $items)->get();
        $discountAmount = Auth::user()->discount_amount;

        foreach ($plItems as $key => $plItem) {
            foreach ($data as $key => $item) {
                if((int)$plItem->id === (int)$item['id']) {
                    $paymentAmount += ((int)$plItem->price * (int)$item['quantity']);
                }
            }
        }

        return $paymentAmount;
    }

    /**
     * 
     */
    public static function getPaymentAmount($id)
    {
        $req = static::find($id);
        $paid = RequestPayment::where('request_id', $id)->sum('amount');

        return round($req->payment_amount - $paid, 2);
    }

    /**
     * 
     */
    public static function createRequest($data, $items)
    {
        $req = new Request();
        $req->payment_amount = $data['payment_amount'];
        $req->user_id = Auth::user()->id;
        $req->save();

        // Save items
        $reqItems = [];
        for ($i = 0; $i < count($items); $i++) { 
            
            $reqItems[] = [
                'quantity' => $items[$i]['quantity'],
                'price_list_item_id' => $items[$i]['id'],
                'request_id' => $req->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

        }

        RequestItem::insert($reqItems);

        return $req;
    }

    /**
     * 
     */
    public static function getById($id)
    {
        $req = static::find($id);

        if(!$req) return abort(404);

        if($req->status === static::STATUS_UNDER_REVISION) {
            return static::getWithRemovedItems($id);
        } else {
            return static::getWithoutRemovedItems($id);
        }
    }

    /**
     * 
     */
    public static function getWithRemovedItems($id)
    {
        return static::where('requests.id', $id)
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('users.name as username', 'requests.*')
            ->with([ 
                'request_payments',
                'request_items' => function($query) {
                    $query
                        ->join('price_list_items', 'price_list_items.id', '=', 'request_items.price_list_item_id')
                        ->join('medicines', 'medicines.id', '=', 'price_list_items.medicine_id')
                        ->join('brands', 'brands.id', '=', 'price_list_items.brand_id')
                        ->select(
                            'request_items.*', 
                            'price_list_items.medicine_id', 
                            'price_list_items.brand_id', 
                            'price_list_items.exp_date', 
                            'medicines.name as medicine_name', 
                            'brands.name as brand_name'
                        );
                } 
            ])
            ->first();
    }

    /**
     * 
     */
    public static function getWithoutRemovedItems($id)
    {
        return static::where('requests.id', $id)
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('users.name as username', 'requests.*')
            ->with([ 
                'request_payments',
                'request_items' => function($query) {
                    $query
                        ->where('request_items.removed', 0)
                        ->join('price_list_items', 'price_list_items.id', '=', 'request_items.price_list_item_id')
                        ->join('medicines', 'medicines.id', '=', 'price_list_items.medicine_id')
                        ->join('brands', 'brands.id', '=', 'price_list_items.brand_id')
                        ->select(
                            'request_items.*', 
                            'price_list_items.medicine_id', 
                            'price_list_items.brand_id', 
                            'price_list_items.exp_date', 
                            'medicines.name as medicine_name', 
                            'brands.name as brand_name'
                        );
                } 
            ])
            ->first();
    }

    /**
     * 
     */
    public static function updateItem($id, $data)
    {
        $item = RequestItem::find($id);
        $item->changed = 1;
        $item->changed_quantity = $data['changed_quantity'];
        $item->comment = $data['comment'];
        $item->save();

        return $item;
    }

    /**
     * 
     */
    public static function removeItem($id, $comment)
    {
        $item = RequestItem::find($id);
        $item->removed = 1;
        $item->comment = $comment;
        $item->save();

        return $item;
    }

    /**
     * 
     */
    public static function prepare($id)
    {
        $req = static::find($id);
        $req->status = static::STATUS_BEING_PREPARED;
        $req->save();

        return $req;
    }
    
    /**
     * 
     */
    public static function ship($id)
    {
        $req = static::find($id);
        $req->status = static::STATUS_SHIPPED;
        $req->save();

        return $req;
    }

    /**
     * 
     */
    public static function changeStatus($id, $status)
    {
        $req = static::find($id);
        $req->status = $status;
        $req->save();

        return $req;
    }

    /**
     * 
     */
    public static function cancel($id, $comment)
    {
        $req = static::find($id);
        $req->status = static::STATUS_CANCELLED;
        $req->cancel_comment = $comment;
        $req->save();

        return $req;
    }
}
