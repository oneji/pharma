<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as RequestModel;
use App\PriceList;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-requests');
    }

    public function index()
    {
        $requests = RequestModel::getAll();

        return view('requests.index', [
            'requests' => $requests
        ]);
    }

    /**
     * 
     */
    public function getById($id)
    {
        $req = RequestModel::getById($id);

        return view('requests.view', [ 'req' => $req ]);
    }

    /**
     * 
     */
    public function create()
    {
        $priceList = PriceList::getTheOnlyPriceList();

        return view('requests.create', [
            'priceList' => $priceList
        ]);
    }

    /**
     * 
     */
    public function store(Request $request)
    {
        if($request->data === null) {
            return response()->json([
                'ok' => false,
                'message' => 'Для создания заявки выберите данные.'
            ]);
        }

        $itemIds = [];

        foreach ($request->data as $item) {
            if($item['id'] !== null) {
                $itemIds[] = $item['id'];
            }
        }

        $paymentAmount = RequestModel::setPaymentAmount($itemIds);
        
        $req = RequestModel::createRequest([
            'request_number' => $request->requestNumber,
            'payment_amount' => $paymentAmount
        ], $request->data);
        
        return response()->json([
            'ok' => true,
            'request' => $req
        ]);
    }

    /**
     * 
     */
    public function edit($id)
    {
        $req = RequestModel::find($id);

        return view('requests.edit');
    }

    /**
     * 
     */
    public function updateItem($id, Request $request)
    {
        $reqItem = RequestModel::updateItem($id, [
            'changed_quantity' => $request->changed_quantity,
            'comment' => $request->comment
        ]);

        return response()->json($reqItem);
    }
    
    /**
     * 
     */
    public function removeItem($id, Request $request)
    {
        $item = RequestModel::removeItem($id, $request->comment);

        return response()->json($item);
    }

    /**
     * 
     */
    public function send($id)
    {
        $req = RequestModel::send($id);

        return redirect()->route('requests.view', [ 'id' => $req->id ]);
    }

    /**
     * 
     */
    public function writeOut($id)
    {
        $req = RequestModel::writeOut($id);

        return redirect()->route('requests.view', [ 'id' => $req->id ]);
    }
}
