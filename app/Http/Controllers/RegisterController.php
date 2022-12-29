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
        // return "aaa";
        $data = User::all();
        // return response()->json($data);
        $message = "Succesfully Data Shown";
        return $this->responseSuccess(200, true, $message, $data);
    }
    public function store(RegisterRequest $request)
    {

        //  return $request;
        DB::beginTransaction();
        try {
            $data = User::create([
                'name' => $request->name,
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

    public function update(RegisterRequest $request, $id)
    {
        //return "aoyon";
        $input = User::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($input) {
                $input->name = $request['name'];
                $input->phone = $request['phone'];
                $input->password = Hash::make($request['password']);
                $input->save();
                $message = "Updated Succesfully";
                DB::commit();
                return $this->responseSuccess(200, true, $message, $input);
            } else {
                $message = "No Data Found";
                return $this->responseError(404, false, $message);
            }
        } catch (QueryException $e) {
            DB::rollBack();
        }
    }


    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
           // return $id;
            // $data = User::findOrFail($id);
            $user = $request->ids;
           // $user=explode(",", $user2);
            // return $user;
            // $user_array=explode(',',$user);
            // return $user_array;
            if ($user) {
                // return $user;
               // User::whereIn('id', [$user])->delete();
                $users = DB::table('users')
                       ->whereIn('id', [$user])
                       ->delete();
               // return $user;
                $message = "Deleted Succesfully";
                DB::commit();
                return $this->responseSuccess(200, true, $message, $users);
            }
        } catch (QueryException $e) {
            DB::rollBack();
        }

        //     try {
        //         User::destroy($request->ids);
        //         return response()->json([
        //             'message' => "Posts Deleted successfully."
        //         ], 200);



        //     }

        // }
    }
}

