<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use App\ActionLog;
use App\Request as RequestModel;

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
     * The request that belongs to the user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /**
     * Get all requests according to the user role
     * 
     * @return collection
     */
    public static function getAll()
    {
        $user = Auth::user();
        $userRole = $user->roles()->first()->name;

        if($userRole === 'head_manager' || $userRole === 'superadministrator') {
            return static::join('users', 'users.id', '=', 'requests.user_id')
                ->select('users.name as username', 'requests.*')
                ->orderBy('priority', 'asc')
                ->get();
        }

        if($userRole === 'manager') {
            $underUsers = User::where('responsible_manager_id', $user->id)->pluck('id');

            return static::whereIn('user_id', $underUsers)
                ->orWhere('user_id', $user->id)
                ->join('users', 'users.id', '=', 'requests.user_id')
                ->select('users.name as username', 'requests.*')
                ->orderBy('priority', 'desc')
                ->get();
        } 
        
        if($userRole === 'logist' || $userRole === 'director') {
            return static::join('users', 'users.id', '=', 'requests.user_id')
                ->select('users.name as username', 'requests.*')
                ->orderBy('priority', 'desc')
                ->get();
        }

        if($userRole === 'cashier') {
            return static::where('requests.status', static::STATUS_SHIPPED)
                ->join('users', 'users.id', '=', 'requests.user_id')
                ->select('users.name as username', 'requests.*')
                ->orderBy('priority', 'desc')
                ->get();
        }

        return static::where('user_id', $user->id)
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('users.name as username', 'requests.*')
            ->orderBy('priority', 'desc')
            ->get();
    }

    /**
     * Set request's payment amount
     * 
     * @param array $items
     * @param array $data
     * 
     * @return double $finalPaymentAmount
     */
    public static function setPaymentAmount($items, $data)
    {
        $paymentAmount = 0;
        $plItems = PriceListItem::whereIn('id', $items)->get();
        $discountAmount = Auth::user()->discount_amount;

        foreach ($plItems as $key => $plItem) {
            foreach ($data as $key => $item) {
                if((int)$plItem->id === (int)$item['id']) {
                    $paymentAmount += ((double)$plItem->price * (double)$item['quantity'] * (double)$plItem->quantity);
                }
            }
        }

        $percentFromPaymentAmount = ($paymentAmount * $discountAmount) / 100;
        $finalPaymentAmount = $paymentAmount - $percentFromPaymentAmount;

        return $finalPaymentAmount;
    }

    /**
     * Get request's payment amount
     * 
     * @param int $id
     * 
     * @return double
     */
    public static function getPaymentAmount($id)
    {
        $req = static::find($id);
        $paid = RequestPayment::where('request_id', $id)->sum('amount');

        return round($req->payment_amount - $paid, 2);
    }

    /**
     * Create and store the request in the db
     * 
     * @param array $data
     * @param array $items
     * 
     * @return object $req
     */
    public static function createRequest($data, $items)
    {
        $req = new Request();
        $req->payment_amount = $data['payment_amount'];
        $req->user_id = Auth::user()->id;
        $req->priority = static::PRIORITY_MEDIUM;
        $req->payment_deadline = null;
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
     * Set the request priority
     * 
     * @param int $id
     * @param int $value
     * 
     * @return
     */
    public static function setPriority($id, $value)
    {
        $req = static::find($id);
        $req->priority = $value;
        $req->save();
    } 

    /**
     * Get the request by id
     * 
     * @param int $id
     * 
     * @return object
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
     * Get the request with removed items
     * 
     * @param int $id
     * 
     * @return object
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
     * Get the request without removed items
     * 
     * @param int $id
     * 
     * @return object
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
     * Update request item
     * 
     * @param int $id
     * @param array $data
     * 
     * @return object $item
     */
    public static function updateItem($id, $data)
    {
        $item = RequestItem::find($id);
        $item->changed = 1;
        $item->changed_quantity = $data['changed_quantity'];
        $item->comment = $data['comment'];
        $item->save();

        $req = RequestModel::where('id', $data['request_id'])->with('request_items')->first();
        $itemIds = [];
        foreach ($req->request_items as $item) {
            $itemIds[] = $item->price_list_item_id;
        }

        $req->payment_amount = static::resetPaymentAmount($itemIds, $req->request_items);
        $req->save();

        return $item;
    }

    /**
     * Reset request payment amount
     * 
     * @param array $items
     * @param array $reqItems
     * 
     * @return double $finalPaymentAmount
     */
    public static function resetPaymentAmount($items, $requestItems)
    {
        $paymentAmount = 0;
        $finalPaymentAmount = 0;
        $discountAmount = Auth::user()->discount_amount;
        $percentFromPaymentAmount = 0;

        $prListItems = PriceListItem::whereIn('id', $items)->get();

        foreach ($prListItems as $listItem) {
            foreach ($requestItems as $requestItem) {
                if($requestItem->removed === 0) {
                    if($listItem->id === $requestItem->price_list_item_id) {
                        $itemQuantity = $requestItem->changed === 1 ? $requestItem->changed_quantity : $requestItem->quantity;
    
                        $paymentAmount += ($listItem->quantity * $listItem->price * $itemQuantity);
                    }
                }
            }
        }

        $percentFromPaymentAmount = ($paymentAmount * $discountAmount) / 100;
        
        $finalPaymentAmount = $paymentAmount - $percentFromPaymentAmount;

        return $finalPaymentAmount;
    }

    /**
     * Remove an item from request
     * 
     * @param int $id
     * @param array $data
     * 
     * @return object $item
     */
    public static function removeItem($id, $data)
    {
        $item = RequestItem::find($id);
        $item->removed = 1;
        $item->comment = $data['comment'];
        $item->save();

        $req = RequestModel::where('id', $data['request_id'])->with('request_items')->first();
        $itemIds = [];
        foreach ($req->request_items as $item) {
            $itemIds[] = $item->price_list_item_id;
        }

        $req->payment_amount = static::resetPaymentAmount($itemIds, $req->request_items);
        $req->save();

        return $item;
    }

    /**
     * Change the request status
     * 
     * @param int $id
     * @param string $type
     * 
     * @return object $req
     */
    public static function changeStatus($id, $status)
    {
        $req = static::find($id);
        $req->status = $status;
        $req->save();

        if($status === static::STATUS_SHIPPED) {
            Sms::send([
                'phone_number' => $req->user->phone,
                'request_number' => $req->id,
                'debtAmount' => $req->payment_amount
            ], Sms::SMS_REQUEST_SHIPPED);
        }

        return $req;
    }

    /**
     * Set the request as cancelled
     * 
     * @param int $id
     * @param string $comment
     * 
     * @return object $req
     */
    public static function cancel($id, $comment)
    {
        $req = static::find($id);
        $req->status = static::STATUS_CANCELLED;
        $req->cancel_comment = $comment;
        $req->save();

        return $req;
    }

    /**
     * Set request's payment deadline
     * 
     * @param int $id
     * @param string $deadline
     */
    public static function setPaymentDeadline($id, $deadline)
    {
        $req = static::find($id);
        $req->payment_deadline = Carbon::createFromFormat('d/m/Y', $deadline);
        $req->save();
    }

    /**
     * Get request by status
     * 
     * @param string $status
     * 
     * @return collection
     */
    public static function getByStatus($status)
    {
        return static::where('status', $status)->get();
    }
}
