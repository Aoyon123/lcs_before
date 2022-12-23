<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        // $id = request()->route('id') ?? null;

        $rules = [
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'email' => 'required|email|max:40|unique:users',
            'phone' => 'required|max:11|min:11|regex:/(01)[0-9]{9}/|unique:users',
            'password' => 'required|min:8',
        ];

        if (request()->isMethod('put') || request()->isMethod('patch')) {
            $rules['password'] = 'nullable|min:8';
        }

        return $rules;
    }
}
