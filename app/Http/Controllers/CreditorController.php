<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Creditor;
use App\User;
use App\Http\Requests\StoreCreditor;

class CreditorController extends Controller
{
    /**
     * Show all creditors
     */
    public function index()
    {
        $creditors = Creditor::getAll();
        $users = User::all();

        // return $creditors;

        return view('creditors.index', [
            'creditors' => $creditors,
            'users' => $users
        ]);
    }

    /**
     * Store a newly created creditor in the db
     */
    public function store(StoreCreditor $request)
    {
        Creditor::store([
            'user_id' => $request->user_id,
            'bill_number' => $request->bill_number,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->route('creditors.index');
    }
}
