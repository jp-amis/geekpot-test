<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use DB;

class UsersController extends Controller
{

    /**
     * GET /users
     * @return array
     */
    public function index(Request $request)
    {
        if ($request->attributes->get('token')->user->perm != User::$PERM_ADMIN) {
            return response()->json([ 'error' => 'You don\'t have acess to this resource' ], 403, [
                'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
            ]);
        }

        if ($request->get('deleted', false)) {
            $users = User::whereNotNull('deleted_at');
        } else {
            $users = User::whereNull('deleted_at');
        }

        if ($request->get('limit')) {
            $users->offset(( intval($request->get('page',
                        1)) * intval($request->get('limit')) ) - intval($request->get('limit')))->limit(intval($request->get('limit')));
        }

        $users = $users->get();

        $usersArr = $users->map(function ($user) {
            return [ 'id'         => $user->obfuscateId(),
                     'email'      => $user->email,
                     'created_at' => $user->created_at->toW3cString()
            ];
        });

        return response()->json([
            'total' => $usersArr->count(),
            'data'  => $usersArr->toArray()
        ], 200, [
            'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
        ]);
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
    public function show(Request $request, $id)
    {
        if ($request->attributes->get('token')->user->perm == User::$PERM_NORMAL && $request->attributes->get('token')->user->obfuscateId() != $id) {
            return response()->json([ 'error' => 'You don\'t have acess to this resource' ], 403, [
                'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
            ]);
        }
        $user = User::find(User::getIdFromObfuscation($id));

        if ( ! $user) {
            return response()->json([ 'error' => 'User not found' ], 404, [
                'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
            ]);
        } else {
            return response()->json([ 'email' => $user->email, 'created_at' => $user->created_at->toW3cString() ], 200,
                [
                    'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
                ]);
        }
    }


    /**
     * DELETE /users/{id}
     * @return array
     */
    public function delete(Request $request, $id)
    {
        if ($request->attributes->get('token')->user->perm == User::$PERM_NORMAL) {
            return response()->json([ 'error' => 'You don\'t have acess to this resource' ], 403, [
                'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
            ]);
        } else {
            if ($request->attributes->get('token')->user->obfuscateId() == $id) {
                return response()->json([ 'error' => 'You can\'t delete yourself' ], 403, [
                    'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
                ]);
            }
        }
        $user = User::find(User::getIdFromObfuscation($id));

        if ( ! $user) {
            return response()->json([ 'error' => 'User not found' ], 404, [
                'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
            ]);
        } else {
            $user->deleted_at = Carbon::now();
            $user->save();

            return response()->json([ 'deleted' => true ], 200, [
                'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
            ]);
        }
    }

    /**
     * PATCH /users/{id}
     * @return array
     */
    public function update(Request $request, $id)
    {
        if ($request->attributes->get('token')->user->perm == User::$PERM_NORMAL && $request->attributes->get('token')->user->obfuscateId() != $id) {
            return response()->json([ 'error' => 'You don\'t have acess to this resource' ], 403, [
                'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
            ]);
        }

        $this->validate($request, [
            'email'    => 'email|unique:users,email,'.User::getIdFromObfuscation($id),
            'password' => '',
        ]);

        $user = User::find(User::getIdFromObfuscation($id));

        if ( ! $user) {
            return response()->json([ 'error' => 'User not found' ], 404, [
                'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
            ]);
        } else {
            if($request->get('email')) {
                $user->email = $request->get('email');
            }

            if($request->get('password')) {
                $user->password = Hash::make($request->get('password'));
            }

            $user->save();

            return response()->json([ 'updated' => true ], 200, [
                'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
            ]);
        }
    }

    /**
     * POST /users/{id}/revoke_access
     * @return array
     */
    public function revoke_access(Request $request, $id)
    {
        if ($request->attributes->get('token')->user->perm == User::$PERM_NORMAL) {
            return response()->json([ 'error' => 'You don\'t have acess to this resource' ], 403, [
                'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
            ]);
        } else {
            if ($request->attributes->get('token')->user->obfuscateId() == $id) {
                return response()->json([ 'error' => 'You can\'t revoke your own access' ], 403, [
                    'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
                ]);
            }
        }

        $user = User::find(User::getIdFromObfuscation($id));

        if ( ! $user) {
            return response()->json([ 'error' => 'User not found' ], 404, [
                'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
            ]);
        } else {
            DB::table('access_tokens')
                ->where('user_id', $user->id)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => Carbon::now()]);

            $user->save();

            return response()->json([ 'access_revoked' => true ], 200, [
                'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
            ]);
        }
    }
}
