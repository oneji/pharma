<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;

class Request extends Model
{
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
        return static::join('users', 'users.id', '=', 'requests.user_id')
            ->select('users.name as username', 'requests.*')
            ->get();
    }

    /**
     * 
     */
    public static function setPaymentAmount($items)
    {
        $paymentAmount = PriceListItem::whereIn('id', $items)->sum('price');
        $discountAmount = Auth::user()->discount_amount;

        return $paymentAmount - (($paymentAmount * $discountAmount) / 100);
    }

    /**
     * 
     */
    public static function createRequest($data, $items)
    {
        $req = new Request();
        $req->request_number = $data['request_number'];
        $req->payment_amount = $data['payment_amount'];
        $req->user_id = Auth::user()->id;
        $req->save();

        // Save items
        $reqItems = [];
        // for ($i = 0; $i < count($items); $i++) { 
            
        //     $reqItems[] = [
        //         'quantity' => $items[$i]['quantity'],
        //         'price_list_item_id' => $items[$i]['id'],
        //         'request_id' => $req->id,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ];

        // }

        foreach ($items as $id => $quantity) {
            if($id !== null) {
                $reqItems[] = [
                    'quantity' => $quantity,
                    'price_list_item_id' => $id,
                    'request_id' => $req->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
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

        if((int) $req->sent === 1) {
            return static::getWithoutRemovedItems($id);
        } else {
            return static::getWithRemovedItems($id);
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
                            'brands.name as brand_name',
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
                        ->where('removed', 0)
                        ->join('price_list_items', 'price_list_items.id', '=', 'request_items.price_list_item_id')
                        ->join('medicines', 'medicines.id', '=', 'price_list_items.medicine_id')
                        ->join('brands', 'brands.id', '=', 'price_list_items.brand_id')
                        ->select(
                            'request_items.*', 
                            'price_list_items.medicine_id', 
                            'price_list_items.brand_id', 
                            'price_list_items.exp_date', 
                            'medicines.name as medicine_name', 
                            'brands.name as brand_name',
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
    public static function send($id)
    {
        $req = static::find($id);
        $req->sent = 1;
        $req->sent_by = Auth::user()->id;
        $req->save();

        return $req;
    }

    /**
     * 
     */
    public static function writeOut($id)
    {
        $req = static::find($id);
        $req->written_out = 1;
        $req->save();

        return $req;
    }
}
