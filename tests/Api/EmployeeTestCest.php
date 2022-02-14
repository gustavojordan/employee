<?php

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tymon\JWTAuth\Facades\JWTAuth;

class EmployeeTestCest
{
    private $employee;

    public function _before(ApiTester $I)
    {
        Artisan::call('migrate:fresh --seed --env=testing');
        $this->employee = Employee::factory()->make()->toArray();
    }

    public function getEmployee(ApiTester $I)
    {
        $I->wantToTest('get employee from seeder');

        $user = User::find(1);
        $token = JWTAuth::fromUser($user);
        $I->amBearerAuthenticated($token);
        $I->sendGET('employee/1');
        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson(['id' => 1]);
    }

    public function listAllEmployees(ApiTester $I)
    {
        $I->wantToTest('list all employees from seeder');

        $user = User::find(1);
        $token = JWTAuth::fromUser($user);
        $I->amBearerAuthenticated($token);
        $I->sendGET('employee');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['total' => 5]);
    }

    public function createEmployee(ApiTester $I)
    {
        $I->wantToTest('create employee');

        $user = User::find(1);
        $token = JWTAuth::fromUser($user);
        $I->amBearerAuthenticated($token);

        $I->sendPOST('employee', $this->employee);

        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson(['id' => 6]);
    }

    public function createEmployeeWrongParameters(ApiTester $I)
    {

        $I->wantToTest('create employee without name should return 422');

        $user = User::find(1);
        $token = JWTAuth::fromUser($user);
        $I->amBearerAuthenticated($token);
        $I->sendPOST('employee', []);

        $I->seeResponseCodeIs(422);
    }

    public function deleteEmployee(ApiTester $I)
    {
        $I->wantToTest('delete employee');
        $user = User::find(1);
        $token = JWTAuth::fromUser($user);
        $I->amBearerAuthenticated($token);
        $I->sendDELETE('employee/1');
        $I->seeResponseCodeIs(200);
    }

    public function updateEmployee(ApiTester $I)
    {
        $I->wantToTest('update employee one');
        $user = User::find(1);
        $token = JWTAuth::fromUser($user);
        $I->amBearerAuthenticated($token);
        $I->sendPUT('employee/1', ['first_name' => 'NameChange']);
        $I->seeResponseCodeIs(202);
        $I->seeResponseContainsJson(['first_name' => 'NameChange']);
    }
}
