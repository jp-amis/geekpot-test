<?php

namespace App\Http\Controllers;

use App\Accesstoken;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{

    /**
     * POST /auth
     * @return array
     */
    public function index(Request $request)
    {

        if(!$request->hasHeader('Authorization')) {
            return response()->json([ 'error' => 'Invalid authorization header' ], Response::HTTP_BAD_REQUEST);
        }

        $authorization = $request->header('Authorization');
        $authorization = explode('Bearer ', $authorization);
        if(sizeof($authorization) != 2 || $authorization[0] != "") {
            return response()->json([ 'error' => 'Invalid authorization header' ], Response::HTTP_BAD_REQUEST);
        }
        $authorization = explode(":", $authorization[1]);

        $user = User::where('api_key', $authorization[0])->first();
        if(!$user) {
            return response()->json([ 'error' => 'API Key is invalid' ], 400);
        }

        if($authorization[1] != hash_hmac('sha1', $user->api_key, $user->getApiSecret())) {
            return response()->json([ 'error' => 'Invalid signature' ], 400);
        }



        return response()->json([], 204, [
            'Authorization' => 'Bearer '.Accesstoken::generate($user)
        ]);
    }

}
