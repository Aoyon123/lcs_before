<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;


class RegisterController extends Controller
{
    public function create(RegisterRequest $request, User $user)
    {
       // return $request->all();

        $user = $user->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        $user->save();
        return response()->json(['message' => 'User Has Been Registered.'], 200);
        return (Hash::make($request->password));

    }
}
