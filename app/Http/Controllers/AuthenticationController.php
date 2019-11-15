<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Lcobucci\JWT\Parser;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if ($user->validateForPassportPasswordGrant($request->password) == $user->password){
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = [
                    'token' => $token,
                    'user' => $user,
                ];
                return response($response, 200);
            } else {
                $response = 'Password mismatch';
                return response($response, 422);
            }
        } else {
            $response = 'User doesn\'t exist';
            return response($response, 422);

        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        $request->user()->token()->delete(); 

        $response = 'You have been successfully logged out!';
        return response($response, 200);
    }
}