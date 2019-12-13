<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Rules\ReCaptcha;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string',
            'name' => 'required|string',
            'first_kata_name' => 'required|string',
            'last_kata_name' => 'required|string',
            'birthday' => 'required|date_format:Y-m-d',
            'gender_id' => 'required|numeric',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|alpha_num',
            'occupation_id' => 'required|numeric',
            'secretquestion_id' => 'required|numeric',
            'answer' => 'required',
            'chkAgree' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha]

        ], [
            'first_name.required' => 'Please enter name',
            'first_name.string' => 'Name must be string',
            'name.required' => 'Please enter name',
            'name.string' => 'Name must be string',
            'first_kata_name.required' => 'Please enter name',
            'first_kata_name.string' => 'Name must be string',
            'last_kata_name.required' => 'Please enter name',
            'last_kata_name.string' => 'Name must be string',
            'birthday.required' => 'Please enter your birthday',
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
            'phone.required' => 'Please enter phone',
            'phone.alpha_num' => 'Phone must be numeric alpha',
            'secretquestion_id.required' => 'Please choose secret question',
            'secretquestion_id.numeric' => 'Secret question value is wrong',
            'occupation_id.required' => 'Please choose Occupation',
            'occupation_id.numeric' => 'Occupation value is wrong',
            'answer.requried' => 'Please enter answer for secret question',
            'chkAgrre.required' => 'Please confirm term of use',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

            'first_name'            => $data['first_name'],
            'last_name'             => $data['name'],
            'kata_first_name'       => $data['first_kata_name'],
            'kata_last_name'        => $data['last_kata_name'],
            'birthday'              => $data['birthday'],
            'gender_id'             => $data['gender_id'],
            'phone'                 => $data['phone'],
            'secret_question_id'    => $data['secretquestion_id'],
            'occupation_id'         => $data['occupation_id'],
            'answer'                => $data['answer']
        ]);
    }
}
