<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\ReCaptcha;

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
        return [
            // 'first_name' => 'required|string',
            'name' => 'required|string',
            /* 'first_kata_name' => 'required|string',
            'last_kata_name' => 'required|string', */
            'birthday' => 'nullable|date_format:Y-m-d',
            'gender_id' => 'required|numeric',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|alpha_num',
            /*'occupation_id' => 'required|numeric',
            'secretquestion_id' => 'required|numeric',
            'answer' => 'required',*/
            'chkAgree' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ];
    }

    /**
    * Get the validation messages that apply to the request
    *
    * @return array
    */
    public function messages() {
        return [
            // 'first_name.required' => 'Please enter name',
            // 'first_name.string' => 'Name must be string',
            'name.required' => 'Please enter name',
            'name.string' => 'Name must be string',
            /* 'first_kata_name.required' => 'Please enter name',
            'first_kata_name.string' => 'Name must be string',
            'last_kata_name.required' => 'Please enter name',
            'last_kata_name.string' => 'Name must be string', */
            /* 'birthday.required' => 'Please enter your birthday', */
            'birthday.date_format' => 'Birthday format is wrong',
            'gender_id.required' => 'Please choose gender',
            'gender_id.numeric' => 'Gender value is wrong',
            'email.required' => 'Please enter email',
            'email.string' => 'Email must be string',
            'email.email' => 'Email is wrong',
            'email.max' => 'Email is too long',
            'email.unique' => 'This email was registered already',
            'password.required' => 'Please enter password',
            'password.string' => 'Passwrod must tring',
            'password.min' => 'The minimum password length is 6',
            'password.confirmed' => 'The confirmation of Password is wrong',
            /* 'phone.required' => 'Please enter phone', */
            'phone.alpha_num' => 'Phone must be numeric alpha',
            // 'secretquestion_id.required' => 'Please choose secret question',
            // 'secretquestion_id.numeric' => 'Secret question value is wrong',
            // 'occupation_id.required' => 'Please choose Occupation',
            // 'occupation_id.numeric' => 'Occupation value is wrong',
            // 'answer.requried' => 'Please enter answer for secret question',
            'chkAgrre.required' => 'Please confirm term of use'
        ];
    }
}
