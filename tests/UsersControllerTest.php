<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class UsersControlerTest extends TestCase
{
    protected function getUser() {
        $user = new \App\User;
        $user->email = uniqid().'@test.com';
        $user->password = -1;
        $user->setApiKey();
        $user->save();

        return $user;
    }

    public function testV1StoreShouldSaveNewUserInDatabase()
    {
        $userEmail = 'test_store_json@user.com';
        $this->post('/api/v1/users', [
            'email'    => $userEmail,
            'password' => '123321'
        ]);

        $this->seeJson([ 'created' => true ])->seeInDatabase('users', [ 'email' => $userEmail ]);
    }

    public function testV1StoreShouldRespond201WhenSuccesfull()
    {
        $userEmail = 'test_status@user.com';
        $this->post('/api/v1/users', [
            'email'    => $userEmail,
            'password' => '123321'
        ]);

        $this->seeStatusCode(201)->seeHeaderWithRegExp('Location', '#/users/[\d]+$#');
    }


    public function testV1StoreValidatesRequiredFieldsOnStore()
    {
        $this->post('/api/v1/users', [ ]);

        $this->seeJsonStructure([
            "email",
            "password"
        ]);
    }

    public function testV1StoreValidatesEmailShouldBeValid()
    {
        $this->post('/api/v1/users', [
            'email'    => 'test_store_json',
            'password' => '123321'
        ]);

        $this->seeJsonEquals(["email" => ["The email must be a valid email address."]]);
    }

    public function testV1StoreValidatesEmailShouldBeUnique()
    {
        $this->post('/api/v1/users', [
            'email'    => 'test_store_json@user.com',
            'password' => '123321'
        ]);

        $this->seeJsonEquals(["email" => ["The email has already been taken."]]);
    }

    public function testV1StoreReturns422StatusCodeWhenInvalidRequest()
    {
        $this->post('/api/v1/users', [ ])->seeStatusCode(\Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    // show
    public function testV1ShowShouldReturnStatus200AndUserDataIfRequestSuccesfull() {
        $user = $this->getUser();
        
        $this->get('/api/v1/users/'.$user->obfuscateId(), [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '[]', $user->getApiSecret())
        ]);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(['email', 'created_at']);
    }

    public function testV1ShowShouldReturnStatus403IfTheUserDoesntHavePermission() {
        $userToGet = $this->getUser();

        $user = $this->getUser();

        $this->get('/api/v1/users/'.$userToGet->obfuscateId(), [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '[]', $user->getApiSecret())
        ]);

        $this->seeStatusCode(403);
    }

    public function testV1ShowShouldReturnStatus400IfTheUserProvidesAnInvalidatedAccessToken() {
        $userToGet = $this->getUser();

        $user = $this->getUser();

        $accessToken = \App\AccessToken::generate($user, true);
        $accessToken->updated_at = \Carbon\Carbon::now()->subHour();
        $accessToken->save();

        $this->get('/api/v1/users/'.$user->obfuscateId(), [
            'Authorization' => 'Bearer '.$accessToken->token.':'.hash_hmac('sha1', '[]', $user->getApiSecret())
        ]);

        $this->seeStatusCode(400);
    }

    public function testV1ShowShouldReturnANewAccessTokenIfTheOldOneNeedsToRefresh() {
        $userToGet = $this->getUser();

        $user = $this->getUser();

        $accessToken = \App\AccessToken::generate($user, true);
        $accessToken->updated_at = \Carbon\Carbon::now()->subMinute(10);
        $accessToken->save();

        $this->get('/api/v1/users/'.$user->obfuscateId(), [
            'Authorization' => 'Bearer '.$accessToken->token.':'.hash_hmac('sha1', '[]', $user->getApiSecret())
        ]);

        $this->seeStatusCode(200);
        $this->seeHasHeader('Authorization');
        $this->assertNotEquals($this->response->headers->get('Authorization'), 'Bearer '.$accessToken->token);
    }

    public function testV1ShowShouldReturn404IfUserNotFound() {
        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $this->get('/api/v1/users/0000000', [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '[]', $user->getApiSecret())
        ]);

        $this->seeStatusCode(404);
    }

}
