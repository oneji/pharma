<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as RequestModel;
use App\PriceList;
use App\RequestPayment;
use App\ActionLog;
use Auth;

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
        $reqPayment = RequestModel::getPaymentAmount($id);
        $reqActions = ActionLog::getRequestActions($id);

        return view('requests.view', [ 
            'req' => $req,
            'reqPayment' => $reqPayment,
            'reqActions' => $reqActions
        ]);
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

        $paymentAmount = RequestModel::setPaymentAmount($itemIds, $request->data);
        
        $req = RequestModel::createRequest([
            'payment_amount' => $paymentAmount,
            'priority' => $request->priority
        ], $request->data);

        ActionLog::create([
            'text' => ActionLog::ACTION_REQUEST_CREATED,
            'request_id' => $req->id
        ]);
        
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

        ActionLog::create([
            'text' => ActionLog::ACTION_REQUEST_EDITED,
            'request_id' => $reqItem->request_id
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
    public function pay(Request $request, $id)
    {
        $req = RequestModel::find($id);
        $paymentAmount = RequestModel::getPaymentAmount($id);
        
        if((double)$paymentAmount < (double)$request->amount) {            
            return redirect()->route('requests.view', [ 'id' => $id ])->withErrors([ 'payment' => 'Сумма выплаты превышает сумму долга.' ]);
        } 

        RequestPayment::pay($id, $request->amount);

        ActionLog::create([
            'text' => ActionLog::ACTION_REQUEST_PAID . ' на сумму ' . $request->amount . ' сомони',
            'request_id' => $id
        ]);

        if((double)$paymentAmount === (double)$request->amount) {
            
            $this->changeStatus($id, 'paid');
        }

        return redirect()->route('requests.view', [ 'id' => $id ]);
    }

    /**
     * 
     */
    public function changeStatus($id, $status)
    {
        RequestModel::changeStatus($id, $status);

        ActionLog::create([
            'text' => ActionLog::getLogTextByRequestStatus($status),
            'request_id' => $id
        ]);

        return redirect()->route('requests.view', [ 'id' => $id ]);
    }

    /**
     * 
     */
    public function cancel($id, Request $request)
    {
        RequestModel::cancel($id, $request->cancel_comment);

        ActionLog::create([
            'text' => ActionLog::ACTION_REQUEST_CANCELLED,
            'request_id' => $id
        ]);

        return redirect()->route('requests.view', [ 'id' => $id ]);
    }
}
