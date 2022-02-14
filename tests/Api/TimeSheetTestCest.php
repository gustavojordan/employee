<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Tymon\JWTAuth\Facades\JWTAuth;

class TimeSheetTestCest
{
    public function _before(ApiTester $I)
    {
        Artisan::call('migrate:fresh --seed --env=testing');
    }

    public function getTimeSheet(ApiTester $I)
    {
        $I->wantToTest('get timesheet');

        $user = User::find(1);
        $token = JWTAuth::fromUser($user);

        $I->amBearerAuthenticated($token);
        $I->sendGET('timesheet');
        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson(['total' => 150]);
    }

    public function getTimeSheetByEmployeeId(ApiTester $I)
    {
        $I->wantToTest('get timesheet by employee id');

        $user = User::find(1);
        $token = JWTAuth::fromUser($user);

        $I->amBearerAuthenticated($token);
        $I->sendGET('timesheet?employees_id=2');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['total' => 30]);
    }

    public function getTimeSheetByDateRange(ApiTester $I)
    {
        $I->wantToTest('get timesheet by date range');

        $user = User::find(1);
        $token = JWTAuth::fromUser($user);

        $I->amBearerAuthenticated($token);
        $I->sendGET('timesheet?start_date='.Carbon::yesterday()->format('Y-m-d H:i:s').'&end_date='.today()->format('Y-m-d H:i:s'));
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['total' => 5]);
    }

    public function getTimeSheetByDateRangeAndEmployeeId(ApiTester $I)
    {
        $I->wantToTest('get timesheet by date range and employee id');

        $user = User::find(1);
        $token = JWTAuth::fromUser($user);

        $I->amBearerAuthenticated($token);
        $I->sendGET('timesheet?employees_id=2&start_date='.Carbon::yesterday()->format('Y-m-d H:i:s').'&end_date='.today()->format('Y-m-d H:i:s'));
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['total' => 1]);
    }
}
