<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;


class RegisterController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $data = User::all();
       // return response()->json($data);
        $message = "Succesfully Data Shown";
        return $this->responseSuccess(200, true,$message,$data);
    }
    public function store(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);

            DB::commit();

            $message = "User Registration Successfull";
            return $this->responseSuccess(200, true, $message, $data);

        } catch (QueryException $e) {
            DB::rollBack();
            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, false, $e->getMessage());
        }
    }

    public function retrive(Request $request,$id){
        DB::beginTransaction();
        try{
            $data = User::findOrFail($id);
            $message = "Admins Found";
            DB::commit();
            return $this->responseSuccess(200, true,$message,$data);
        }
        catch (QueryException $e) {
            DB::rollBack();
           // return $this->responseError(403, false, $message);
            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, false, $e->getMessage());
        }

    }

    public function update(Request $reques,$id){
        $data = User::find($id);
    }


}
