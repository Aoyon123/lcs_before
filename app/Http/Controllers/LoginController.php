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
//use Auth;
class LoginController extends Controller
{
    use ResponseTrait;

    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login', "register", "logout"]]);
    }
    public function login(Request $request)
    {
    //     $input = $request->all();

    //     auth()->attempt(['email' => $input['email'], 'password' => $input['password']]);

    //     return auth()->user();
    //    return auth()->user();
    //         return Auth::attempt(['email' => $request->email, 'password' => $request->password]);
    //         $user = User::where('email', $request->email)->first();
    //       //  return $request->email;
    //         if ($user) {
    //             if (Hash::check($request->password, $user->password)) {
    //                 // Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]);

    //               //  $this->authenticated($request, $user);
    //               if(Auth::attempt(['email'=>$user['email'],'password'=>$user['password']])){
    //                 $tokenCreated = $user->createToken("authToken");
    //                 $data = [
    //                     'user' => $user,
    //                     'access_token' => $tokenCreated->accessToken,
    //                     'token_type' => 'Bearer',
    //                     'expires_at' => Carbon::parse($tokenCreated->token->expires_at)->toDateTimeString()
    //                 ];
    //                 $message = "Login Successfully";

    //                 return $this->responseSuccess(200, true, $message, $data);
    //             } else {
    //                 $message = "Invalid credentials";
    //                 return $this->responseError(403, false, $message);
    //             }
    //         } else {
    //             $message = "Invalid credentials";
    //             return $this->responseError(403, false, $message);
    //         }

        $input = $request->all();

        if (!empty($input)) {
            //  return $input;
             if (auth()->guard('api')->attempt(['email' => $input['email'], 'password' => $input['password']])) {
               // if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
                $user = Auth::user();
                   //return $user;

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

    public function logout(Request $request)
    {

        // $user = auth('api')->user()->logout;
    //     $user = Auth::user();
    //     // $user->revoke();

    //    return auth()->user();

    //     // return $request->user();
    //     if ($request->user()) {
    //         echo 'hello';
    //         // echo $request->user()->email;
    //         $request->user()->tokens()->delete();
    //     }

    //     // $user = Auth::user();
    //     // return $user;
         $message = "Succesfully Log Out";
    //    return $message;
      //  $request->user()->tokens()->delete();

        // $token = $request->user()->token();
        // $token->revoke();
        // return $token;
        //   auth()->logout();
         // return "Aoyon";
        //  return auth()->user();
     // return  $request->user()->token()->revoke();
        // Auth::user()->tokens->each(function ($token, $key) {
        //     $token->delete();
        // });

        //  $this->user->token()->revoke();
        //     auth()->logout();
        return auth()->logout();

        return $this->responseDone(200, true, $message);
    }
}
