<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class UsersController extends Controller
{

    function getMyself(Request $request)
    {
        return $request->user();
    }

    //
    function create(CreateUserRequest $request)
    {
        $apiToken = Str::random(60);
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'api_token' => $apiToken,
        ]);
    }


    function login(LoginRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (!$user)
            return Response::json([
                "success" => "false",
                "message" => "no user found"
            ], 404);

        //check the password

        $valid = Hash::check($request->input("password"), $user->password);
        if (!$valid) {
            return Response::json([
                "success" => "false",
                "message" => "password is not correct"
            ], 401);
        }

        $token = $user->createToken("api_token");

        return ['accessToken' => $token->plainTextToken];
    }

    function logout(Request $request)
    {
        // this will revoke all of the user tokens
        $request->user()->tokens()->delete();
        return true;
    }
}
