<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EducationQualification;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use App\Http\Requests\EducationQualificationRequest;

class EducationQualificationController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        //return "aaa";

        $data = EducationQualification::all();
        if (!empty($data)) {
            $message = "Succesfully Data Shown";
            return $this->responseSuccess(200, true, $message, $data);
        } else {
            $message = "Invalid credentials";
            return $this->responseError(403, false, $message);
        }
    }
    public function store(EducationQualificationRequest $request)
    {
        //  return $request;
        DB::beginTransaction();
        try {
            $data = EducationQualification::create([
                'qualification_name' => $request->qualification_name,
                'subject' => $request->subject,
                'passing_year' => $request->passing_year,
                'result' => $request->result,
                'user_id' => $request->user_id,
            ]);
            DB::commit();
            $message = "Data Inserted Successfull";
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
            $data = EducationQualification::findOrFail($id);
            $message = "Data Found";
            DB::commit();
            return $this->responseSuccess(200, true, $message, $data);
        } catch (QueryException $e) {
            DB::rollBack();
        }

    }

    public function update(EducationQualificationRequest $request, $id)
    {
        //return "aoyon";
        $input = EducationQualification::findOrFail($id);
        //return $input;

        DB::beginTransaction();
        try {
            if ($input) {
                // return $input;
                $input->qualification_name = $request['qualification_name'];
                $input->subject = $request['subject'];
                $input->passing_year = $request['passing_year'];
                $input->result = $request['result'];
              //  $input->user_id = $request['user_id'];
                $input->save();
                //return $request;
                $message = "Updated Succesfully";
                //return $message;
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


    public function destroy($id)
    {
        $user = EducationQualification::findOrFail($id);
        //return $user;
        try {
            if ($user) {
               // return $user;
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
