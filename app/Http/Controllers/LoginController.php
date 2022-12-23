<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use App\Http\Controllers\createToken;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    use ResponseTrait;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', "register", "logout"]]);
    }
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password) && $user) {

                $tokenCreated = $user->createToken("authToken");
                $data = [
                    'user' => $user,
                    'access_token' => $tokenCreated->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse($tokenCreated->token->expires_at)->toDateTimeString()
                ];
                $message = "Login Successfully";

                return $this->responseSuccess(200, true, $message, $data);
            } else {
                $message = "Invalid credentials";
                return $this->responseError(403, false, $message);
            }
        } else {
            $message = "Invalid credentials";
            return $this->responseError(403, false, $message);
        }

    }


    public function logout()
    {

        //return Auth::user()->token()->revoke();

        // return response()->json([
        //     'message'=>'User Logout Success'
        // ]);
        // $message = "Succesfully Log Out";
        //    // return $message;
        auth()->logout();
        return $this->responseDone(200, true, $message);
        //     return response()->json(['message' => 'Successfully logged out']);
    }
}
