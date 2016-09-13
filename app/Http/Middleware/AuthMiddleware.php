<?php

namespace App\Http\Middleware;

use App\AccessToken;
use App\User;
use Closure;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->hasHeader('Authorization')) {
            return response()->json([ 'error' => 'Invalid authorization header' ], 400);
        }

        $authorization = $request->header('Authorization');
        $authorization = explode('Bearer ', $authorization);
        if(sizeof($authorization) != 2 || $authorization[0] != "") {
            return response()->json([ 'error' => 'Invalid authorization header' ], 400);
        }
        $authorization = explode(":", $authorization[1]);

        $accessToken = AccessToken::where('token', $authorization[0])->first();
        if(!$accessToken) {
            return response()->json([ 'error' => 'This Access Token is invalid' ], 400);
        }

        if(!$accessToken->isValid()) {
            return response()->json([ 'error' => 'Invalid Access Token' ], 400);
        }

        if($authorization[1] != hash_hmac('sha1', sizeof($request->all()) ? json_encode($request->all()) : '{}', $accessToken->user->getApiSecret())) {
            return response()->json([ 'error' => 'Invalid signature' ], 400, [
                'Authorization' => 'Bearer '.$accessToken->refresh()
            ]);
        }

        $request->attributes->add(['token' => $accessToken]);

        return $next($request);
    }
}
