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
        $user->setApiKey();
        $user->save();

        Mail::raw('Hi! Welcome to GeekPot IT Consulting API server.' . PHP_EOL . 'Follow in the the attachment is your credentials.',
            function ($msg) use ($user) {
                $msg->subject('Welcome!');
                $msg->attachData('API Key,API Secret' . PHP_EOL . $user->api_key . ',' . $user->getApiSecret(),
                    'credentials.csv', [ 'mime' => 'text/csv' ]);
                $msg->to([ $user->email ]);
            });

        return response()->json([ 'created' => true ], 201, [
            'Location' => route('users.show', [ 'id' => $user->obfuscateId() ])
        ]);
    }

    /**
     * GET /users/{id}
     * @return array
     */
    public function show(Request $request, $id) {
        if($request->attributes->get('token')->user->perm == User::$PERM_NORMAL
            && $request->attributes->get('token')->user->obfuscateId() != $id) {
            return response()->json([ 'error' => 'You don\'t have acess to this resource'], 403, [
                'Authorization' => 'Bearer '.$request->attributes->get('token')->refresh()
            ]);
        }
        $user = User::find(User::getIdFromObfuscation($id));

        if(!$user) {
            return response()->json([ 'error' => 'User not found' ], 404, [
                'Authorization' => 'Bearer '.$request->attributes->get('token')->refresh()
            ]);
        } else {
            return response()->json([ 'email' => $user->email, 'created_at' => $user->created_at->toW3cString() ], 200, [
                'Authorization' => 'Bearer '.$request->attributes->get('token')->refresh()
            ]);
        }
    }
}
