<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Session\Session;


class RegisterController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $data = User::all();
        // return response()->json($data);
        $message = "Succesfully Data Shown";
        return $this->responseSuccess(200, true, $message, $data);
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

    public function retrieve($id)
    {
        DB::beginTransaction();
        try {

            $data = User::findOrFail($id);
            $message = "Admins Found";
            DB::commit();
            return $this->responseSuccess(200, true, $message, $data);
        } catch (QueryException $e) {
            DB::rollBack();
        }

    }


    public function update(Request $request,$id)
    {
        $input = User::find($id);
       // return $input;
        if ($input) {
            $input->first_name = $request['first_name'];
            $input->last_name = $request['last_name'];
            $input->email = $request['email'];
            $input->phone = $request['phone'];
            $input->password = $request['password'];
            $input->save();
            $message = "Updated Succesfully";
            return $this->responseSuccess(200, true, $message, $input);
        }
        else{
            $message = "No Data Found";
            return $this->responseError(404, false, $message);
        }

    }


    public function destroy(Request $request, $id)
    {

        $user = User::findOrFail($id);
        try {
            if ($user) {
                //return $user;
                $user->delete();

                $message = "Deleted Succesfully";
                return $this->responseSuccess(200, true, $message, $user);
            } else {
                $message = "Data cannot be deleted";
                return $this->responseError(403, false, $message);
            }
        } catch (QueryException $e) {
            DB::rollBack();
        }

    }

}
