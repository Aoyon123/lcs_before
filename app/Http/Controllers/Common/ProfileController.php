<?php

namespace App\Http\Controllers\Common;

use random;
//use Illuminate\Http\File;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Models\AcademicQualification;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Session\Session;

class ProfileController extends Controller
{

    use ResponseTrait;
    public function update(Request $request)
    {
        // info($request->all());

        //  return $request->all();

        // DB::beginTransaction();

        // try {
        $user = User::findOrFail($request->id);
        $request->validate([
            'name' => 'required|string|max:50',
            'phone' => 'max:15|min:11|regex:/(01)[0-9]{9}/',
            'password' => 'required|min:8',
            'address' => 'required|max:50',
            'nid' => 'required|max:50',
            'dob' => 'required|max:50',
            'gender' => 'required|max:10',
        ]);

        if ($request->hasFile('profile_image')) {
            $request->validate([
                'profile_image' => 'max:2024|mimes:jpeg,jpg,png,gif',
            ]);
        }

        // $image = $request->file('profile_image');
        // $image = str_replace('data:image/png;base64,', '', $image);
        // $imageName = $request->type . '_' . $request->phone . '.' . $image->getClientOriginalExtension();
        // $destinationPath = public_path('uploads/profile/');
        // $image->move($destinationPath, $imageName);
        // $image_path_save = '/uploads/profile/' . $imageName;



        if ($request->profile_image) {
            $image_parts = explode(";base64,", $request->profile_image);
            $filename_path = md5(time(). '_' . $request->phone) . ".png";
            $decoded = base64_decode($image_parts[1]);
            file_put_contents(public_path() . "/uploads/profile/" . $filename_path, $decoded);
            $profile_image_path = "/uploads/profile/" . $filename_path;
            if (File::exists($profile_image_path)) {
                File::delete($profile_image_path);
            }
        } else {
            $profile_image_path = $user->profile_image;
        }



        // $image = $request->file('image');
        // $imageName = 'suit_' . uniqid() . '.' . $image->getClientOriginalExtension();
        // $destinationPath = public_path('uploads/suit/');
        // $image->move($destinationPath, $imageName);
        // if (!empty($target->image)) {
        //     $prvFileName = 'public/uploads/suit/' . $target->image;
        //     if (File::exists($prvFileName)) {
        //         File::delete($prvFileName);
        //     }
        // }


        // $file = base64_decode($request['profile_image']);
        // $safeName = random_int(1, 4).'.'.'png';
        // $success = file_put_contents(public_path().'/uploads/'.$safeName, $file);

        if ($request->type === 'consultant') {
            $request->validate([
                'years_of_experience' => 'required',
                'current_profession' => 'required',
                'email' => 'required|email|unique:users,email,'. $user->id,
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

            //nid_front
            if ($request->nid_front) {
                $image_parts = explode(";base64,", $request->nid_front);
                $filename_path = md5(time() . uniqid()) . ".png";
                $decoded = base64_decode($image_parts[1]);
                file_put_contents(public_path() . "/uploads/nid_front/" . $filename_path, $decoded);
                $nid_front_image_path = "/uploads/nid_front/" . $filename_path;
                if (File::exists($nid_front_image_path)) {
                    File::delete($nid_front_image_path);
                }
            } else {
                $nid_front_image_path = $user->nid_front;
            }

            //nid_back
            if ($request->nid_back) {
                $image_parts = explode(";base64,", $request->nid_back);
                $filename_path = md5(time() . uniqid()) . ".png";
                $decoded = base64_decode($image_parts[1]);
                file_put_contents(public_path() . "/uploads/nid_back/" . $filename_path, $decoded);
                $nid_back_image_path = "/uploads/nid_back/" . $filename_path;
                if (File::exists($nid_back_image_path)) {
                    File::delete($nid_back_image_path);
                }
            } else {
                $nid_back_image_path = $user->nid_back;
            }

            // $nidFront = $request->file('nid_front');
            // $nidFrontimageName = 'nidFront_' . $request->email . '.' . $nidFront->getClientOriginalExtension();
            // $destinationPath = public_path('uploads/nid_front/');
            // $nidFront->move($destinationPath, $nidFrontimageName);
            // $FrontNid_image_path_save = '/uploads/nid_front/' . $nidFrontimageName;


            // $nidBack = $request->file('nid_back');
            // $nidBackimageName = 'nid_back' . $request->email . '.' . $nidBack->getClientOriginalExtension();
            // $destinationPath = public_path('uploads/nid_back/');
            // $nidBack->move($destinationPath, $nidBackimageName);
            // $BackNid_image_path_save = '/uploads/nid_back/' . $nidBackimageName;

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
            'profile_image' => $profile_image_path,
            'years_of_experience' => $request->years_of_experience ?? $user->years_of_experience,
            'current_profession' => $request->current_profession ?? $user->current_profession,
            'nid_front' => $nid_front_image_path,
            'nid_back' => $nid_back_image_path,
        ]);

        if($user->type === 'consultant'){
            if($request->accademics){

                foreach($request->accademics as $key => $accademics){
                    if($request->accademics){
                        $data = AcademicQualification::updateOrCreate([
                            'education_level'=> 
                        ]);
                    }
                    return [$accademics, $key];
                }

            }
        }


        $message = $request->type . " Updated Succesfully";
        return $this->responseSuccess(200, true, $message, $user);


        //     DB::commit();
        //     return $this->responseSuccess(200, true, $message, $user);

        // } catch (QueryException $e) {
        //     DB::rollBack();
        // }
    }


    public function updatePassword(Request $request)
    {
        $user = User::findOrFail($request->id);
        if ($request->id) {

            $request->validate([
                'old_password' => 'required|min:8',
                'new_password' => 'required|min:8',
            ]);
            //  return $user->password;
            if ($user && Hash::check($request->old_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);

                $message = "Password Updated Succesfully";

                return $this->responseSuccess(200, true, $message, $user);
            } else {
                $message = "Old Password Does Not Match";
                return $this->responseError(403, false, $message);
            }
        }
    }

// public function dataShow(Request $request){
//     if ($request->type === 'consultant'){

//     }
// }


}
