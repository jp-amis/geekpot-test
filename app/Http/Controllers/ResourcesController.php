<?php

namespace App\Http\Controllers;

use App\Accesstoken;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class ResourcesController extends Controller
{

    /**
     * POST /auth
     * @return array
     */
    public function index(Request $request)
    {
        $user = $request->attributes->get('token')->user;
        $data = [
            'host' => env('APP_HOST'),
            'basePath' => '/api/v1'
        ];
        $apis = [ ];
        if ($user->perm == User::$PERM_ADMIN) {
            $apis["/users"] = [
                "get"  => [
                    "summary"    => "List users",
                    "parameters" => [
                        [
                            "name"        => "deleted",
                            "in"          => "query",
                            "description" => "If true makes the api return only the deleted users",
                            "required"    => false,
                            "type"        => "boolean",
                            "default"     => "false"
                        ],
                        [
                            "name"        => "page",
                            "in"          => "query",
                            "description" => "Page number if the limit parameter is passed",
                            "required"    => false,
                            "type"        => "integer",
                            "default"     => "1"
                        ],
                        [
                            "name"        => "limit",
                            "in"          => "query",
                            "description" => "Limit of records to return",
                            "required"    => false,
                            "type"        => "integer",
                            "default"     => "unlimited"
                        ]
                    ]
                ],
                "post" => [
                    "summary"    => "Create new users",
                    "parameters" => [
                        [
                            "name"        => "email",
                            "in"          => "body",
                            "description" => "Valid e-mail for the user",
                            "required"    => true,
                            "type"        => "string",
                        ],
                        [
                            "name"        => "password",
                            "in"          => "body",
                            "description" => "Password for the user",
                            "required"    => true,
                            "type"        => "string",
                        ]
                    ]
                ]
            ];

            $apis["/users/:id"] = [
                "get"  => [
                    "summary"    => "Show data from the user especified in :id",
                    "parameters" => [
                        [
                            "name"        => "id",
                            "in"          => "path",
                            "description" => "Id of the user to get data from",
                            "required"    => true,
                            "type"        => "integer",
                        ]
                    ]
                ],
                "delete"  => [
                    "summary"    => "Delete the user especified in :id",
                    "parameters" => [
                        [
                            "name"        => "id",
                            "in"          => "path",
                            "description" => "Id of the user to be deleted",
                            "required"    => true,
                            "type"        => "integer",
                        ]
                    ]
                ],
                "patch"  => [
                    "summary"    => "Update data from the user especified in :id",
                    "parameters" => [
                        [
                            "name"        => "email",
                            "in"          => "body",
                            "description" => "Valid e-mail for the user",
                            "required"    => false,
                            "type"        => "string",
                        ],
                        [
                            "name"        => "password",
                            "in"          => "body",
                            "description" => "Password for the user",
                            "required"    => false,
                            "type"        => "string",
                        ]
                    ]
                ],
            ];

            $apis["/users/:id/revoke_access"] = [
                "post"  => [
                    "summary"    => "Revoke all access tokens from a user",
                    "parameters" => [
                        [
                            "name"        => "id",
                            "in"          => "path",
                            "description" => "Id of the user to revoke access from",
                            "required"    => true,
                            "type"        => "integer",
                        ]
                    ]
                ],
            ];
        } else {
            $apis["/users/".$user->obfuscateId()] = [
                "get"  => [
                    "summary"    => "Show your data",
                    "parameters" => []
                ],
                "patch"  => [
                    "summary"    => "Update your data",
                    "parameters" => [
                        [
                            "name"        => "email",
                            "in"          => "body",
                            "description" => "Valid e-mail for the user",
                            "required"    => false,
                            "type"        => "string",
                        ],
                        [
                            "name"        => "password",
                            "in"          => "body",
                            "description" => "Password for the user",
                            "required"    => false,
                            "type"        => "string",
                        ]
                    ]
                ],
            ];
        }

        $data['paths'] = $apis;

        return response()->json($data, 200, [
            'Authorization' => 'Bearer ' . $request->attributes->get('token')->refresh()
        ]);
    }

}
