<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Creditor;
use App\User;
use App\Http\Requests\StoreCreditor;
use App\Imports\CreditorImport;
use Maatwebsite\Excel\Facades\Excel;

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

    /**
     * Get creditor's info by id
     * 
     * @param int $id
     * 
     * @return collection
     */
    public function getById($id)
    {
        $creditor = Creditor::getById($id);

        return response()->json([
            'ok' => true,
            'creditor' => $creditor
        ]);
    }

    public function importExcel(Request $request)
    {
        if($request->hasFile('excel_file')) {
            $items = Excel::toArray(new CreditorImport, $request->file('excel_file'));
            $parsedItems = [];

            for($j = 3; $j < count($items[0]); $j++) {
                if( $items[0][$j][0] !== null && 
                    $items[0][$j][3] !== null &&
                    $items[0][$j][4] !== null &&
                    $items[0][$j][5] !== null) {
                    
                    $parsedItems[] = [
                        'bill_number' => $items[0][$j][0],
                        'date' => $items[0][$j][3],
                        'user' => $items[0][$j][4],
                        'amount' => $items[0][$j][5],
                    ];

                }
            }

            return $parsedItems;
        } else {
            return [
                'ok' => false
            ];
        }
    }
}
