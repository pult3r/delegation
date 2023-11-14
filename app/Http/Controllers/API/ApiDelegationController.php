<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Delegation;
use App\Models\CountryRate;

use DateTime;
use DateInterval;
use DatePeriod;
use Exception;
use Validator;

class ApiDelegationController extends BaseController
{
    private const HTTP_STATUST_OK = 200;
    private const DEFAULT_CURRENCY = 'PL';

    /**
     * Method generate new user Id 
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getauthcode(Request $request): JsonResponse
    {
        $data = array();

        $data['userid'] = md5(time());
        $data['startdatetime'] = date('Y-m-d H:i:s', 0);
        $data['enddatetime'] = date('Y-m-d H:i:s', 0);
        $data['countrycode'] = self::DEFAULT_CURRENCY;

        try {
            $delegation = Delegation::create($data);

            return $this->sendResponse(
                'success',
                'New user authorisation code added. Your authorisation code : ' . $delegation->userid,
                ['authcode' => $delegation->userid],
                self::HTTP_STATUST_OK
            );
        } catch (Exception $e) {
            return $this->sendError('Error.',  $e->getMessage());
        }
    }

    /**
     * Method storing delegation data in databese, in case of errors return error list
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storedelegation(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'userid' => ['required', 'max:32', 'min:32'],
            'countrycode' => ['required', 'max:2', 'min:2'],
            'startdate' => ['required', 'date_format:Y-m-d'],
            'starttime' => ['required', 'date_format:H:i'],
            'enddate' => ['required', 'date_format:Y-m-d'],
            'endtime' => ['required', 'date_format:H:i']
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(
                'error',
                'Check validation fields',
                ['validationFields' => $validator->messages()],
                self::HTTP_STATUST_OK,
                'validation'
            );
        }

        // County code validation 
        $countryCodeList = DB::table('countryrate')
            ->where('countrycode', '=', $request->countrycode)
            ->get()
            ->count();

        if(!$countryCodeList) {
            return $this->sendResponse(
                'error',
                'This Country code is not permitted',
                ['validationFields' => (object) ['countrycode' => 'Country code is not permitted']],
                self::HTTP_STATUST_OK,
                'validation'
            );
        }

        $data = $request->all();
        $userid = $data['userid'];

        // try to find user id in database, if not exist return error
        $delegationList = DB::table('delegation')
            ->where('userid', '=', $userid)
            ->get()
            ->count();

        if (!$delegationList) {
            return $this->sendResponse(
                'error',
                'User not exist in database. Please use button : \'Create your user Id\'',
                ['validationFields' => (object) ['userid' => 'User not exist in database']],
                self::HTTP_STATUST_OK,
                'validation'
            );
        }


        // if start date is greater than end date - return error
        $data['startdatetime'] = $data['startdate'] . " " . $data['starttime'] . ":00";
        $data['enddatetime'] = $data['enddate'] . " " . $data['endtime'] . ":00";

        $sd = $data['startdatetime'];
        $ed = $data['enddatetime'];

        if ($data['startdatetime'] > $data['enddatetime']) {

            return $this->sendResponse(
                'error',
                'Check validation fields',
                [
                    'validationFields' => (object) [
                        'startdate' => 'Start date/time cannot be greater than end date/time',
                        'starttime' => 'Start date/time cannot be greater than end date/time',
                        'enddate' => 'Start date/time cannot be smaller than end date/time',
                        'endtime' => 'Start date/time cannot be smaller than end date/time'
                    ]
                ],
                self::HTTP_STATUST_OK,
                'validation'
            );
        }

        // if delegation in this time period already exist return error
        $delegationListCount = DB::table('delegation')
            ->where('userid', '=', $userid)
            ->where(function ($query) use ($sd, $ed) {
                $query
                    ->whereBetween('startdatetime', [$sd, $ed])
                    ->orWhereBetween('enddatetime', [$sd, $ed])
                    ->orWhere(function ($orQuery) use ($sd, $ed) {
                        $orQuery->where([
                            ['startdatetime', '<', $sd],
                            ['enddatetime', '>', $sd],
                            ['startdatetime', '<', $ed],
                            ['enddatetime', '>', $ed]
                        ]);
                    });
            })
            ->get()
            ->count();

        if ($delegationListCount > 0) {
            return $this->sendResponse(
                'error',
                'You can\'t set two delegations in the same time',
                [],
                self::HTTP_STATUST_OK
            );
        }

        // add delegation to data base
        $delegation = Delegation::create($data);

        if ($delegation) {
            return $this->sendResponse(
                'success',
                'Your delegation has been added',
                [],
                self::HTTP_STATUST_OK
            );
        } else {
            return $this->sendResponse(
                'error',
                'Problem with Database!',
                [],
                self::HTTP_STATUST_OK
            );
        }
    }


    /**
     * Method return Json list of delegations
     * 
     * @param 32 characters string $userId
     * @return \Illuminate\Http\JsonResponse
     */
    //public function delegationreport(): JsonResponse
    public function delegationreport($userId): JsonResponse
    {
        // TODO : make userId validation 
        $delegationList = DB::table('delegation')
            ->select(
                'delegation.id',
                'delegation.userid',
                'delegation.startdatetime',
                'delegation.enddatetime',
                'delegation.countrycode',
                'countryrate.currency',
                'countryrate.price'
            )
            ->join('countryrate', 'delegation.countrycode', '=', 'countryrate.countrycode')
            ->where('userid', '=', $userId)
            ->where('startdatetime', '!=', date('Y-m-d', 0))
            ->get();

        if ($delegationList->isEmpty()) {
            return $this->sendResponse(
                'error',
                'No records for this UserId',
                [],
                self::HTTP_STATUST_OK
            );            
        }

        $resultList = array();

        foreach ($delegationList as $item) {
            $hPerDay = array();

            $firstDate = date('Y-m-d', strtotime($item->startdatetime));
            $lastDate = date('Y-m-d', strtotime($item->enddatetime));

            $startCalcDate = $item->startdatetime;
            $endCalcDate = $item->enddatetime;

            $dayCounter = 0;
            $multiplier = 1;
            $amountDue = 0;

            for ($unixDate = strtotime($firstDate); $unixDate <= strtotime($lastDate); $unixDate += 86400) {
                $res = array();

                $dateFrom = date('Y-m-d H:i:s', $unixDate);
                $dateTo = date('Y-m-d H:i:s', $unixDate + 86400);

                $weekDay = date('w', $unixDate);

                if ($weekDay == 0 || $weekDay == 6) {
                    $multiplier = 0;
                } elseif ($dayCounter >= 7) {
                    $multiplier = 2;
                } else {
                    $multiplier = 1;
                }

                $hours = 24;
                if ($startCalcDate > $dateFrom && $startCalcDate < $dateTo) {
                    $cd = new DateTime($startCalcDate);
                    $fd = new DateTime($dateTo);

                    $hours = $diff = $fd->diff($cd)->h;
                } elseif ($endCalcDate > $dateFrom && $endCalcDate < $dateTo) {
                    $cd = new DateTime($endCalcDate);
                    $fd = new DateTime(date('Y-m-d H:i:s', $unixDate));

                    $hours = $diff = $fd->diff($cd)->h;
                }

                if ($hours >= 8) {
                    $amountDue += $multiplier * $item->price;
                }

                // Just for calculation debug ! - remove this later 
                $hPerDay[date('Y-m-d', $unixDate)] = array(
                    'dayFrom' => $dateFrom,
                    'dayTo' => $dateTo,
                    'startCalcDate' => $startCalcDate,
                    'endCalcDate' => $endCalcDate,
                    'hours' => $hours,
                    'day' => date('D w', $unixDate),
                    'dayPosition' => ++$dayCounter,
                    'multiplier' => $multiplier,
                );
            }

            $res = array(
                'start' => $item->startdatetime,
                'end' => $item->enddatetime,
                'country' => $item->countrycode,
                'amount_due' => $amountDue,
                'currency' => $item->currency
            );

            $resultList[] = $res;
        };

        return $this->sendResponse(
            'success',
            'Delegation report',
            $resultList,
            self::HTTP_STATUST_OK
        );
    }
}
