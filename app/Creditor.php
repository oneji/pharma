<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Creditor extends Model
{
    /**
     * Get all creditors
     * 
     * @return collection
     */
    public static function getAll()
    {
        return DB::table('creditors')
            ->join('users', 'users.id', '=', 'creditors.user_id')
            ->leftJoin('companies', 'users.company_id', '=', 'companies.id')
            ->selectRaw(DB::raw('sum(creditors.amount) as total, creditors.user_id, users.name, users.username, users.phone, companies.name as company_name'))
            ->groupBy('creditors.user_id', 'users.name', 'users.id', 'users.username', 'users.phone', 'companies.name')
            ->get();
    }

    /**
     * Store a newly created creditor in the db
     * 
     * @param array $data
     */
    public static function store($data)
    {
        $creditor = new Creditor();
        $creditor->user_id = $data['user_id'];
        $creditor->bill_number = $data['bill_number'];
        $creditor->amount = $data['amount'];
        $creditor->date = Carbon::createFromFormat('d/m/Y', $data['date']);
        $creditor->save();
    }

    /**
     * Get creditor's info by id
     * 
     * @param int $id
     * 
     * @return collection
     */
    public static function getById($id)
    {
        return static::where('user_id', $id)->get();
    }

    /**
     * 
     */
    public static function getCreditsAmount($id)
    {
        $total = DB::table('creditors')
            ->where('creditors.user_id', $id)
            ->join('users', 'users.id', '=', 'creditors.user_id')
            ->leftJoin('companies', 'users.company_id', '=', 'companies.id')
            ->selectRaw(DB::raw('sum(creditors.amount) as total'))
            ->groupBy('creditors.user_id', 'users.name', 'users.id', 'users.username', 'users.phone', 'companies.name')
            ->first();

        $items = Creditor::where('user_id', $id)->get();

        return [
            'total' => $total,
            'items' => $items
        ];
    } 
}
