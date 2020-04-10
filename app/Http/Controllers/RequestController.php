<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as RequestModel;
use App\RequestItem;
use App\PriceList;
use App\PriceListItem;
use App\RequestPayment;
use App\ActionLog;
use App\User;
use App\Sms;
use Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RequestPaid;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-requests');
    }

    /**
     * Show all requests
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = RequestModel::getAll();

        return view('requests.index', [
            'requests' => $requests
        ]);
    }

    /**
     * Get the reques by id
     * 
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
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
     * Show create page for request
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $priceList = PriceList::getTheOnlyPriceList();

        return view('requests.create', [
            'priceList' => $priceList
        ]);
    }

    /**
     * Store the newly created request in the db
     * 
     * @param   \Illuminate\Http\Request $request
     * 
     * @return  \Illuminate\Http\ResponseJson
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
            'payment_amount' => $paymentAmount
        ], $request->data);

        ActionLog::create([
            'text' => ActionLog::ACTION_REQUEST_CREATED,
            'request_id' => $req->id
        ]);

        Sms::send([
            'phone_number' => Auth::user()->phone,
            'request_number' => $req->id
        ], Sms::SMS_REQUEST_CREATED);
        
        return response()->json([
            'ok' => true,
            'request' => $req
        ]);
    }

    /**
     * Show the edit page for request
     * 
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $req = RequestModel::find($id);

        return view('requests.edit');
    }

    /**
     * Update an item in request
     * 
     * @param   \Illuminate\Http\Request $request
     * @param   int $id
     * 
     * @return  \Illuminate\Http\ResponseJson
     */
    public function updateItem($id, Request $request)
    {
        $item = RequestModel::updateItem($id, [
            'changed_quantity' => $request->changed_quantity,
            'comment' => $request->comment,
            'request_id' => $request->request_id
        ]);

        ActionLog::create([
            'text' => ActionLog::ACTION_REQUEST_EDITED,
            'request_id' => $item->request_id
        ]);

        return response()->json($item);
    }
    
    /**
     * Remove request item from the request
     * 
     * @param   \Illuminate\Http\Request $request
     * @param   int $id
     * 
     * @return  \Illuminate\Http\ResponseJson
     */
    public function removeItem($id, Request $request)
    {
        $item = RequestModel::removeItem($id, [
            'comment' => $request->comment,
            'request_id' => $request->request_id
        ]);

        return response()->json($item);
    }

    /**
     * Pay the request's debt
     * 
     * @param   \Illuminate\Http\Request $request
     * @param   int $id
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
     * Change request's status
     * 
     * @param int $id
     * @param string $status
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
     * Set request's status as cancelled
     * 
     * @param   int $id
     * @param   \Illuminate\Http\Request $request
     * 
     * @return
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

    /**
     * Set request's priority
     * 
     * @param   int $id
     * @param   \Illuminate\Http\Request $request
     * 
     * @return  \Illuminate\Http\ReponseJson
     */
    public function setPriority($id, Request $request) {
        RequestModel::setPriority($id, $request->priority);

        ActionLog::create([
            'text' => ActionLog::ACTION_REQUEST_PRIORITY_CHANGED,
            'request_id' => $id
        ]);

        return response()->json([ 'ok' => true ]);
    }

    /**
     * Set request's payment deadline
     * 
     * @param   int $id
     * @param   \Illuminate\Http\Request $request
     * 
     * @return  \Illuminate\Http\ReponseJson
     */
    public function setPaymentDeadline($id, Request $request)
    {
        RequestModel::setPaymentDeadline($id, $request->deadline);

        ActionLog::create([
            'text' => ActionLog::ACTION_REQUEST_SET_DEADLINE,
            'request_id' => $id
        ]);

        return response()->json([ 'ok' => true ]);
    }

    /**
     * Get requessts by status
     * 
     * @param string $status
     * 
     * @return collection $requests
     */
    public function getByStatus($status)
    {
        $requests = RequestModel::getByStatus($status);

        return view('requests.by-status', [
            'requests' => $requests
        ]);
    }
}
