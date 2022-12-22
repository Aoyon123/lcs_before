<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\createToken;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    use ResponseTrait;
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $message = "Login Isn't Successful";
            return $this->responseError(401, $message);
        }

        if (Hash::check($request->password, $user->password)) {
            $tokenCreated = $user->createToken("authToken");

            $data = [
                // 'user'=>$user,
                'access_token' => $tokenCreated->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenCreated->token->expires_at)->toDateTimeString()
            ];
            $message = "Login Successfully";

            return $this->responseSuccess(200, $message, $data);
        }else{
            $message = "Password Does Not Match";
            return $this->responseError(403, $message);
        }

    }

    public function logout()
    {
        $message = "Succesfully Log Out";
        auth()->logout();
        return $this->responseDone(200, $message);
        // return response()->json(['message' => 'Successfully logged out']);
    }
}
