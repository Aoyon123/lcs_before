<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\createToken;
use Illuminate\Database\QueryException;

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

        $user = User::orWhere('email', $request->email_or_phone)
            ->orWhere('phone', $request->email_or_phone)->first();
        if (!$user) {
            $message = "Invalid credentials";
            return $this->responseError(403, false, $message);
        }
        //   Auth::attempt(['email' => $request['email_or_phone'], 'password' => $request['password']]);
        if (Auth::guard('api')->attempt(['email' => $request['email_or_phone'], 'password' => $request['password']])) {
            $data = [
                'user' => $user,
                'access_token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOGEzMmJjOTgxZTg5OTRlMDRlNTUwOTZkZjJlNjY4YWMwNzcxODBkYWU0OTJmODk0ODc2MWZkYjk5NTdkNDU2NGE3ZmJhMzNhZTg2ZmVkYmEiLCJpYXQiOjE2NzE3NDg0MTQuNzU2NDE2LCJuYmYiOjE2NzE3NDg0MTQuNzU2NDIsImV4cCI6MTcwMzI4NDQxNC43MTE4NjgsInN1YiI6IjEzIiwic2NvcGVzIjpbXX0.XqQYoDXfXw095TDkJbZU-Ua5uC67nAP0ygYv1G_fxdh6Lgkzj2I1YhXLbK_EoFh5AnU16lQ49vEKoL8r7GbwajeXpQKimXcQ7D0z3aktNX61uEDgf0vTZfocGw7biAU2Uj1L-SM3pdd62wL17VQ4V9oq-f1BWkIkQODh8L3gzUPdmPVBL-ukTwNd48Lge6jn2d75nDE3zc_MINc1iSWAjvZC5KX9WMLwECiSX532izDhMklXBhC4eo9SAc0ShFhUgYiiUUYIvrGnZHVmjcYPwE5GE0H-NLjFWpVKpzgi6KUkBlR434eXoqgbZqW1lbi_t7NwLENNj9DY79dgRQjyVXYnFhqPhOPmqmB-EMeodF4eiWibeQaZuHGXkTfyjTNKkxngZZG7l8AbSiEWB_yRw7inCozwnjvwqmmJdJs0VZtIQRcYG_xipjLJpcszeTnpB_4ON7BuDuRphVB6z_20w3eTaDtbH4i3K4BkOH2YOTfhbAW7Gn8e6vIMkNzCwo22pFsjUazFy9FPGAEDwEYdYm3pBf9_J1PN88NLBnOHylooR5sl6P8uoX1lKKj-pNKcEG2tJt1wNQAcNVUpPDMONzfZTFfv5yuQqOEUHctKrVu4C6hlPIFdtrpJIA3O8JbjLGHWCm4FqWjYsB8wJxn_MiETmHiGt8WHmvg_ylK1hHE',
                'token_type' => 'Bearer',
                // 'expires_at' => Carbon::parse($tokenCreated->token->expires_at)->toDateTimeString()
            ];
        }
        $message = "Login Successfully";

        return $this->responseSuccess(200, true, $message, $data);


        // $input = $request->all();

        // if (!empty($input)) {
        //     //  return $input;
        //    //  if (auth()->attempt(['phone' => $input['phone'], 'password' => $input['password']])) {
        //      //  $credentials = ['phone' => $input->phone, 'password' => $input->password];
        //         if (Auth::guard('api')->attempt(['phone' => $input['phone'], 'password' => $input['password']])) {
        //         $user = Auth::user();
        //            //return $user;

        //         $tokenCreated = $user->createToken("authToken");
        //         $data = [
        //             'user' => $user,
        //             'access_token' => $tokenCreated->accessToken,
        //             'token_type' => 'Bearer',
        //             'expires_at' => Carbon::parse($tokenCreated->token->expires_at)->toDateTimeString()
        //         ];
        //         $message = "Login Successfully";

        //         return $this->responseSuccess(200, true, $message, $data);
        //     } else {
        //         $message = "Invalid credentials";
        //         return $this->responseError(403, false, $message);
        //     }
        // } else {
        //     $message = "Invalid credentials";
        //     return $this->responseError(403, false, $message);
        // }
    }

    public function profile($id)
    {
        $user = User::with('experiances','academics')->where('id',$id)->first();
        $message = " ";
        return $this->responseSuccess(200, true, $message, $user);

    }

    // public function profileRetrieve($id)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $data = User::findOrFail($id);
    //         $message = "Data Found";
    //         DB::commit();
    //         return $this->responseSuccess(200, true, $message, $data);
    //     } catch (QueryException $e) {
    //         DB::rollBack();
    //     }
    // }

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
