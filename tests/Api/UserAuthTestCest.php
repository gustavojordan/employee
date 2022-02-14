<?php

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthTestCest
{
    // tests
    public function testLoginIsSuccess(ApiTester $I)
    {
        $I->wantToTest('login is success');
        // create user data using factory
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('123456')
        ]);

        $I->sendPOST('auth/login', ['email' => 'test@test.com', 'password' => '123456']);

        $I->seeResponseCodeIs(200);
    }

    public function testLoginIsFailed(ApiTester $I)
    {
        $I->wantToTest('login is failed');

        User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('123456')
        ]);

        $I->sendPOST('auth/login', ['email' => 'test@test.com', 'password' => '1111111111']);

        $I->seeResponseCodeIs(401);
    }

    public function authenticatedUserSuccessFetchProfile(ApiTester $I)
    {
        $I->wantToTest('authenticated user success fetch profile');

        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('123456')
        ]);

        $token = JWTAuth::fromUser($user);

        $I->amBearerAuthenticated($token);

        $I->sendGET('auth/me');

        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson(['id' => $user->id]);
    }
}
