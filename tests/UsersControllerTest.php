<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class UsersControlerTest extends TestCase
{

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

        $this->seeStatusCode(201);
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

}
