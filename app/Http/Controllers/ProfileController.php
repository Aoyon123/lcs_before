<?php

namespace App\Http\Controllers;

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

class ProfileController extends Controller
{

    use ResponseTrait;
    public function update(Request $request)
    {
        return $request->all();

        DB::beginTransaction();
        try {
            $user = User::findOrFail($request->id);
            $request->validate([
                'name' => 'required|string|max:50',
                'phone' => 'max:15|min:11|regex:/(01)[0-9]{9}/',
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
            $imageName = 'citizen_' . $request->phone . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/profile/');
            $image->move($destinationPath, $imageName);
            $image_path_save = '/uploads/profile/' . $imageName;

            if ($request->type === 'consultant') {
                $request->validate([
                    'email' => 'email|unique:users,email',
                    'years_of_experience' => 'required',
                    'current_profession' => 'required',
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

                $nidFront = $request->file('nid_front');
                $nidFrontimageName = 'nidFront_' . $request->email . '.' . $nidFront->getClientOriginalExtension();
                $destinationPath = public_path('uploads/nid_front/');
                $nidFront->move($destinationPath, $nidFrontimageName);
                $FrontNid_image_path_save = '/uploads/nid_front/' . $nidFrontimageName;


                $nidBack = $request->file('nid_back');
                $nidBackimageName = 'nid_back' . $request->email . '.' . $nidBack->getClientOriginalExtension();
                $destinationPath = public_path('uploads/nid_back/');
                $nidBack->move($destinationPath, $nidBackimageName);
                $BackNid_image_path_save = '/uploads/nid_back/' . $nidBackimageName;

            }

            $user->update([
                'name' => $request->name ?? $user->name,
                'phone' => $request->phone ?? $user->phone,
                'email' => $request->email ?? $user->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'address' => $request->address ?? $user->address,
                'nid' => $request->nid ?? $user->nid,
                'dob' => $request->dob ?? $user->dob,
                'status' => $request->status ?? $user->status,
                'gender' => $request->gender ?? $user->gender,
                'profile_image' => $image_path_save ?? null,
                'years_of_experience' => $request->years_of_experience ?? $user->years_of_experience,
                'current_profession' => $request->current_profession ?? $user->current_profession,
                'nid_front' => $FrontNid_image_path_save ?? null,
                'nid_back' => $BackNid_image_path_save ?? null,
            ]);

            $message = $request->type . " Updated Succesfully";
            DB::commit();
            return $this->responseSuccess(200, true, $message, $user);

        } catch (QueryException $e) {
            DB::rollBack();
        }
    }
}
