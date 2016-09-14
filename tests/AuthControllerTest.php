<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthControlerTest extends TestCase
{

    protected function getUser() {
        $user = new \App\User;
        $user->email = uniqid().'@test.com';
        $user->password = \Illuminate\Support\Facades\Hash::make(-1);
        $user->setApiKey();
        $user->save();

        return $user;
    }

    public function testV1IndexShouldReturn204()
    {
        $user = $this->getUser();
        $this->post('/api/v1/auth', [], [
            'Authorization' => 'Bearer '.$user->api_key.":".hash_hmac('sha1', $user->api_key, $user->getApiSecret())
        ]);

        $this->seeStatusCode(204);
    }

    public function testV1IndexShouldContainAnTokenInHeaders()
    {
        $user = $this->getUser();
        $this->post('/api/v1/auth', [], [
            'Authorization' => 'Bearer '.$user->api_key.":".hash_hmac('sha1', $user->api_key, $user->getApiSecret())
        ]);

        $this->seeHasHeader('Authorization');
    }

    public function testV1IndexShouldReturnBadRequestWhenTheTokensDontMatch()
    {
        $user = $this->getUser();
        $this->post('/api/v1/auth', [], [
            'Authorization' => 'Bearer '.$user->api_key.":".hash_hmac('sha1', "123", $user->getApiSecret())
        ]);

        $this->seeStatusCode(\Illuminate\Http\Response::HTTP_BAD_REQUEST);
    }

}
