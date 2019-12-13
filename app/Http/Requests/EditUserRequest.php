<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
        return [
            'name' => 'required|string',
            'birthday' => 'nullable|date_format:Y-m-d',
            'password'  =>  'nullable|min:6',
            'password_confirm' => 'nullable|same:password',
            'gender_id' => 'required|numeric',
            'phone' => 'nullable|alpha_num'
        ];
    }

    /**
    * Get the validation messages that apply to the request
    *
    * @return array
    */
    public function messages() {
        return [
            'name.required' => 'Please enter name',
            'name.string' => 'Name must be string',
            'password.min' => 'Your password must at least 6 characters',
            'password_confirm.same' => 'Password confirm is not available',
            'birthday.date_format' => 'Birthday format is wrong',
            'gender_id.required' => 'Please choose gender',
            'gender_id.numeric' => 'Gender value is wrong',
            'phone.alpha_num' => 'Phone must be numeric alpha',
        ];
    }
}
