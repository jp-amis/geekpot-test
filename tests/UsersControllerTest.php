<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class UsersControlerTest extends TestCase
{
    protected function getUser() {
        $user = new \App\User;
        $user->email = uniqid().'@test.com';
        $user->password = \Illuminate\Support\Facades\Hash::make(-1);
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
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
        ]);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(['email', 'created_at']);
    }

    public function testV1ShowShouldReturnStatus403IfTheUserDoesntHavePermission() {
        $userToGet = $this->getUser();

        $user = $this->getUser();

        $this->get('/api/v1/users/'.$userToGet->obfuscateId(), [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
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
            'Authorization' => 'Bearer '.$accessToken->token.':'.hash_hmac('sha1', '{}', $user->getApiSecret())
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
            'Authorization' => 'Bearer '.$accessToken->token.':'.hash_hmac('sha1', '{}', $user->getApiSecret())
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
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
        ]);

        $this->seeStatusCode(404);
    }

    // List
    protected function mapUsersList($users) {
        return $users->map(function($user) {
            return [ 'id' => $user->obfuscateId(), 'email' => $user->email, 'created_at' => $user->created_at->toW3cString() ];
        });
    }

    public function testV1IndexShouldReturnStatusCode200AndArrayOfAllUsersAndTotalCount() {
        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $this->get('/api/v1/users', [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
        ]);

        $users = \App\User::whereNull('deleted_at')->get();

        $toCheck = $this->mapUsersList($users);

        $this->seeJsonEquals([
            'total' => sizeof($users),
            'data' => $toCheck->toArray()
        ]);
        $this->seeStatusCode(200);
    }

    public function testV1IndexShouldReturnStatusCode200AndArrayOf5FirstUsersAndTotalCount() {
        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $this->get('/api/v1/users?page=1&limit=5', [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{"page":"1","limit":"5"}', $user->getApiSecret())
        ]);

        $users = \App\User::whereNull('deleted_at')->offset(0)->limit(5)->get();

        $toCheck = $this->mapUsersList($users);

        $this->seeJsonEquals([
            'total' => sizeof($users),
            'data' => $toCheck->toArray()
        ]);
        $this->seeStatusCode(200);
    }

    public function testV1IndexShouldReturnStatusCode200AndArrayOf2UsersFromPage3AndTotalCount() {
        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $this->get('/api/v1/users?page=3&limit=2', [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{"page":"3","limit":"2"}', $user->getApiSecret())
        ]);

        $users = \App\User::whereNull('deleted_at')->offset(4)->limit(2)->get();

        $toCheck = $this->mapUsersList($users);

        $this->seeJsonEquals([
            'total' => sizeof($users),
            'data' => $toCheck->toArray()
        ]);
        $this->seeStatusCode(200);
    }

    public function testV1IndexShouldReturnStatusCode200AndArrayOfAllDeletedUsersAndTotalCount() {
        $user = $this->getUser();
        $user->deleted_at = \Carbon\Carbon::now();
        $user->save();

        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $this->get('/api/v1/users?deleted=true', [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{"deleted":"true"}', $user->getApiSecret())
        ]);

        $users = \App\User::whereNotNull('deleted_at')->get();

        $toCheck = $this->mapUsersList($users);

        $this->seeJsonEquals([
            'total' => sizeof($users),
            'data' => $toCheck->toArray()
        ]);
        $this->seeStatusCode(200);
    }

    public function testV1IndexShouldReturnStatusCode403IfUserIsForbidden() {
        $user = $this->getUser();

        $this->get('/api/v1/users', [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
        ]);

        $this->seeStatusCode(403);
    }

    // delete
    public function testV1DeleteUserShouldReturn200() {
        $userToDelete = $this->getUser();

        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $this->delete('/api/v1/users/'.$userToDelete->obfuscateId(), [],[
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
        ]);

        $this->seeStatusCode(200);
        $this->seeJsonEquals(['deleted' => true]);
    }

    public function testV1DeleteUserShouldReturnForbiddenIfUserTriesToDeleteHimself() {
        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $this->delete('/api/v1/users/'.$user->obfuscateId(), [],[
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
        ]);

        $this->seeStatusCode(403);
        $this->seeJsonEquals(['error' => 'You can\'t delete yourself']);
    }

    public function testV1DeleteUserShouldReturnForbiddenIfUserTriesToDeleteWithoutPermission() {
        $user = $this->getUser();
        $user->save();

        $this->delete('/api/v1/users/'.$user->obfuscateId(), [],[
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
        ]);

        $this->seeStatusCode(403);
    }

    public function testV1DeleteUserShouldReturnNotFoundIfUserTriesToDeleteAInexistentUser() {
        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $this->delete('/api/v1/users/00000', [],[
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
        ]);

        $this->seeStatusCode(404);
    }

    // update
    public function testV1UpdateUserShouldReturn200() {
        $userToPatch = $this->getUser();

        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $data = [
            'email' => 'new@example.com',
            'password' => 'thisIsTheNewPassword'
        ];
        $this->patch('/api/v1/users/'.$userToPatch->obfuscateId(), $data, [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', json_encode($data), $user->getApiSecret())
        ]);

        $this->seeStatusCode(200);
        $this->seeJsonEquals(['updated' => true]);
        $this->seeInDatabase('users', ['id' => $userToPatch->id, 'email' => $data['email']]);
    }

    public function testV1UpdateNormalUserShouldBeAbleToUpdateHimself() {
        $user = $this->getUser();
        $user->save();

        $data = [
            'email' => 'new_normal@example.com',
            'password' => 'thisIsTheNewPassword'
        ];
        $this->patch('/api/v1/users/'.$user->obfuscateId(), $data, [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', json_encode($data), $user->getApiSecret())
        ]);

        $this->seeStatusCode(200);
        $this->seeJsonEquals(['updated' => true]);
        $this->seeInDatabase('users', ['id' => $user->id, 'email' => $data['email']]);
    }

    public function testV1UpdateUserShouldReturnForbiddenIfUserDoesntHavePermission() {
        $userToPatch = $this->getUser();

        $user = $this->getUser();
        $user->save();

        $data = [
            'email' => 'new_fail@example.com',
            'password' => 'thisIsTheNewPassword'
        ];
        $this->patch('/api/v1/users/'.$userToPatch->obfuscateId(), $data, [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', json_encode($data), $user->getApiSecret())
        ]);

        $this->seeStatusCode(403);
    }

    public function testV1UpdateUserShouldReturnNotFoundIfUpdatedUserIsInexistent() {
        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $data = [
            'email' => 'new_fail_inexistent@example.com',
            'password' => 'thisIsTheNewPassword'
        ];
        $this->patch('/api/v1/users/000000', $data, [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', json_encode($data), $user->getApiSecret())
        ]);

        $this->seeStatusCode(404);
    }

    public function testV1UpdateUserShouldValidateEmailUniqueIfOtherUserUsesIt() {
        $userToPatch = $this->getUser();

        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->email = "unique@example.com";
        $user->save();

        $data = [
            'email' => $user->email,
            'password' => 'thisIsTheNewPassword'
        ];
        $this->patch('/api/v1/users/'.$userToPatch->obfuscateId(), $data, [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', json_encode($data), $user->getApiSecret())
        ]);

        $this->seeJsonEquals(["email" => ["The email has already been taken."]]);
    }

    public function testV1UpdateUserShouldValidateEmailUniqueIfOtherUserUsesItButNotTheUpdatedUser() {
        $userToPatch = $this->getUser();

        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $data = [
            'email' => $userToPatch->email,
            'password' => 'thisIsTheNewPassword'
        ];
        $this->patch('/api/v1/users/'.$userToPatch->obfuscateId(), $data, [
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', json_encode($data), $user->getApiSecret())
        ]);

        $this->seeStatusCode(200);
        $this->seeInDatabase('users', ['id' => $userToPatch->id, 'email' => $data['email']]);
    }

    // revoke access
    public function testV1RevokeAccessUserShouldReturn200() {
        $userToRevoke = $this->getUser();
        \App\AccessToken::generate($userToRevoke);
        \App\AccessToken::generate($userToRevoke);
        \App\AccessToken::generate($userToRevoke);
        \App\AccessToken::generate($userToRevoke);

        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $this->post('/api/v1/users/'.$userToRevoke->obfuscateId().'/revoke_access', [],[
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
        ]);

        $this->seeStatusCode(200);
        $this->seeJsonEquals(['access_revoked' => true]);
    }

    public function testV1RevokeAccessUserShouldReturnForbiddenIfUserTriesToRevokeHimself() {
        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $this->post('/api/v1/users/'.$user->obfuscateId().'/revoke_access', [],[
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
        ]);

        $this->seeStatusCode(403);
        $this->seeJsonEquals(['error' => 'You can\'t revoke your own access']);
    }

    public function testV1RevokeAccessUserShouldReturnForbiddenIfUserTriesToDeleteWithoutPermission() {
        $user = $this->getUser();
        $user->save();

        $this->post('/api/v1/users/'.$user->obfuscateId().'/revoke_access', [],[
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
        ]);

        $this->seeStatusCode(403);
    }

    public function testV1RevokeAccessUserShouldReturnNotFoundIfUserTriesToDeleteAInexistentUser() {
        $user = $this->getUser();
        $user->perm = \App\User::$PERM_ADMIN;
        $user->save();

        $this->post('/api/v1/users/00000/revoke_access', [],[
            'Authorization' => 'Bearer '.\App\AccessToken::generate($user).':'.hash_hmac('sha1', '{}', $user->getApiSecret())
        ]);

        $this->seeStatusCode(404);
    }
}
