<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationQualificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'qualification_name' => 'required|string',
            'subject' => 'required|max:30',
            'passing_year' => 'required|max:10',
            'result' => 'required|max:6',
            'user_id' => 'required|int|exists:users,id|unique:education_qualifications,user_id,'
        ];

        if (request()->isMethod('put') || request()->isMethod('patch')) {
            $rules['user_id']  = '';
        }

        return $rules;
    }
}
