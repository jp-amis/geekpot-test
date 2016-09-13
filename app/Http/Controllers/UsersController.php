<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class UsersController extends Controller
{

    /**
     * GET /users
     * @return array
     */
    public function index()
    {
        return [ ];
    }


    /**
     * POST /users
     * @return array
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'email'    => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user           = new User;
        $user->email    = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->api_key  = Hash::make(uniqid());
        $user->save();

        Mail::raw('Hi! Welcome to GeekPot IT Consulting API server.' . PHP_EOL . 'Follow in the the attachment is your credentials.',
            function ($msg) use($user) {
                $msg->subject('Welcome!');
                $msg->attachData('API Key,API Secret' . PHP_EOL . $user->api_key.','.$user->getApiSecret(), 'credentials.csv',
                    [ 'mime' => 'text/csv' ]);
                $msg->to([ $user->email ]);
            });

        return response()->json([ 'created' => true ], 201);
    }
}
