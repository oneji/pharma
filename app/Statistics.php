<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Request as RequestModel;
use App\RequestPayment;

class Statistics extends Model
{
    /**
     * Get full statistics
     * 
     * @return array
     */
    public static function getFull()
    {
        $usersCount = User::all()->count();
        $requestsCount = RequestModel::all()->count();
        $medicineCount = Medicine::all()->count();
        $brandsCount = Brand::all()->count();
        $totalDebtAmount = static::getTotalDebtAmount();
        $allRequestTypesCount = static::getAllRequestTypesCount();

        return [
            'usersCount' => $usersCount,
            'requestsCount' => $requestsCount,
            'medicineCount' => $medicineCount,
            'brandsCount' => $brandsCount,
            'totalDebtAmount' => $totalDebtAmount,
            'allRequestTypesCount' => $allRequestTypesCount
        ];
    }

    /**
     * Get total debt amount
     * 
     * @return double
     */
    public static function  getTotalDebtAmount()
    {
        $requestsPaymentAmount = round(RequestModel::sum('payment_amount'), 2);
        $allRequestsPayments = round(RequestPayment::sum('amount'), 2);

        return $requestsPaymentAmount - $allRequestsPayments;
    }

    /**
     * Get all request types count
     * 
     * @return array
     */
    public static function getAllRequestTypesCount()
    {
        $allRequests = RequestModel::all();
        $underRevisionRequests = [];
        $sentRequests = [];
        $preparedRequests = [];
        $shippedRequests = [];
        $paidRequests = [];
        $cancelledRequests = [];

        foreach ($allRequests as $idx => $request) {
            if($request->status === RequestModel::STATUS_UNDER_REVISION) {
                $underRevisionRequests[] = $request;
            }

            if($request->status === RequestModel::STATUS_SENT) {
                $sentRequests[] = $request;
            }

            if($request->status === RequestModel::STATUS_BEING_PREPARED) {
                $preparedRequests[] = $request;
            }

            if($request->status === RequestModel::STATUS_SHIPPED) {
                $shippedRequests[] = $request;
            }

            if($request->status === RequestModel::STATUS_PAID) {
                $paidRequests[] = $request;
            }

            if($request->status === RequestModel::STATUS_CANCELLED) {
                $cancelledRequests[] = $request;
            }
        }

        return [
            'underRevision' => count($underRevisionRequests),
            'sent' => count($sentRequests),
            'prepared' => count($preparedRequests),
            'shipped' => count($shippedRequests),
            'paid' => count($paidRequests),
            'cancelled' => count($cancelledRequests)
        ];
    }
}
