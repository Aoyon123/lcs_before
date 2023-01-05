<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
//use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
    public function store(Request $request)
    {
        if ($request->type === 'citizen') {
            $request->validate([
                'name' => 'required|string|max:50',
                'phone' => 'max:11|min:11|regex:/(01)[0-9]{9}/|unique:users',
                'password' => 'required|min:8',
                'type' => 'required',
            ]);
        } elseif ($request->type === 'consultant') {
            $request->validate([
                'name' => 'required|string|max:50',
                'email' => 'email|unique:users,email',
                'password' => 'required|min:8',
                'type' => 'required',
            ]);
        }

        DB::beginTransaction();
        try {
            $data = User::create([
                'name' => $request->name,
                'phone' => $request->phone ?? null,
                'email' => $request->email ?? null,
                'type' => $request->type,
                'password' => Hash::make($request->password)
            ]);
            DB::commit();
            $message = $request->type . " Registration Successfull";
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

    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            if ($request->type === 'citizen') {
                $request->validate([
                    'name' => 'required|string|max:50',
                    'phone' => 'max:15|min:11|regex:/(01)[0-9]{9}/|unique:users',
                    'password' => 'required|min:8',
                    'address' => 'required|max:50',
                    'nid' => 'required|max:50',
                    'dob' => 'required|max:50',
                    'status' => 'required',
                    'gender' => 'required|max:10',

                ]);
                if ($request->hasFile('profile_image')) {
                    $request->validate([
                        'profile_image' => 'max:2024|mimes:jpeg,jpg,png,gif',
                    ]);
                }
                $image = $request->file('profile_image');
                $imageName = 'citizen_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/profile/');
                $image->move($destinationPath, $imageName);
                if (!empty($request->profile_image)) {
                    $prvFileName = 'public/uploads/profile/' . $request->profile_image;
                    if (File::exists($prvFileName)) {
                        File::delete($prvFileName);
                    }
                }
                // $target->image = $imageName;
                $user->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'password' => $request->password,
                    'address' => $request->address,
                    'nid' => $request->nid,
                    'dob' => $request->dob,
                    'status' => $request->status,
                    'gender' => $request->gender,
                    'profile_image' => $request->imageName,

                ]);

            } elseif ($request->type === 'consultant') {
                $request->validate([
                    'name' => 'required|string|max:50',
                    'email' => 'email|unique:users,email',
                    'password' => 'required|min:8',
                    'nid' => 'required|max:50',
                    'dob' => 'required|max:50',
                    'gender' => 'required|max:10',
                    'address' => 'required|max:50',
                    'years_of_experience' => 'required',
                    'current_profession' => 'nullable',
                ]);

                if ($request->hasFile('nid_front')) {
                    $request->validate([
                        'nid_front' => 'required|max:2024|mimes:jpeg,jpg,png,gif',
                    ]);
                }

                if ($request->hasFile('nid_back')) {
                    $request->validate([
                        'nid_back' => 'required|max:2024|mimes:jpeg,jpg,png,gif',
                    ]);
                }

                $image = $request->file('nid_front');
                $imageNidFront = 'nid_front' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/nid_front/');
                $image->move($destinationPath, $imageNidFront);
                if (!empty($request->profile_image)) {
                    $prvFileName = 'public/uploads/nid_front/' . $request->nid_front;
                    if (File::exists($prvFileName)) {
                        File::delete($prvFileName);
                    }
                }

                $image = $request->file('nid_back');
                $imageNidBack = 'nid_front' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/nid_back/');
                $image->move($destinationPath, $imageNidBack);
                if (!empty($request->profile_image)) {
                    $prvFileName = 'public/uploads/nid_back/' . $request->nid_front;
                    if (File::exists($prvFileName)) {
                        File::delete($prvFileName);
                    }
                }


                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'nid' => $request->nid,
                    'dob' => $request->dob,
                    'nid_front' => $request->imageNidFront,
                    'nid_back' => $request->imageNidBack,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'years_of_experience' => $request->years_of_experience,
                    'current_profession' => $request->current_profession,
                ]);
            }

            $message = $request->type . " Updated Succesfully";
            DB::commit();
            return $this->responseSuccess(200, true, $message, $user);

        } catch (QueryException $e) {
            DB::rollBack();
        }
    }


    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            // return $request->all();
            $users = DB::table('users')->whereIn('id', $request->all());
            $users->delete();
            $message = "Deleted Succesfully";
            DB::commit();
            return $this->responseSuccess(200, true, $message, []);

        } catch (QueryException $e) {
            DB::rollBack();
        }
    }
}
