<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Validator;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Mail\VerifyEmail;
use App\Mail\ResetPassword;

use App\Models\Setting;
use App\Models\Param;
use App\Models\User;

class AccountController extends Controller
{
    public function getLogin() {
        if(Auth::check()) {
            if(!is_null(Auth::user()->email_verified_at)) {
                if(route('login') != url()->previous()) {
                    return redirect(url()->previous());
                } else {
                    return redirect('/');
                }
            } else {
                return redirect()->route('verify');
            }
        }

        $msgErr = null;
        if(session('login_failed')) {
            $msgErr = session('login_failed');
        }
        $email = session('email', '');

        $this->data['email'] =session('email', '');
        if(session('previous_url')) {
            $this->data['previous_url'] = session('previous_url');
        } else {
            $this->data['previous_url'] = url()->previous();
        }

        return view('auth.login')->withErrors(['login_failed' => $msgErr])->with($this->data);
    }

    public function postLogin(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'Please enter email',
            'email.email' => 'Please check email form',
            'password.required' => 'Please enter password',
            'password.min' => 'Please check password again'
        ]);

        if($validator->fails()) {
            return redirect()->route('login')->with(['login_failed' => $validator->errors()->all(), 'email' => $request->email, 'previous_url' => $request->previous_url]);
        }


        $email = $request->email;
        $password = $request->password;
        $rememeber = $request->remember;

        if(Auth::attempt(['email' => $email, 'password' => $password], true)) {
            if(!is_null(Auth::user()->email_verified_at)) {
                if(empty($request->previous_url) || $request->previous_url == route('login')) {
                    return redirect()->route('home');
                } else {
                    return redirect($request->previous_url);
                }
            } else {
                return redirect()->route('verify');
            }
        }
        return redirect()->route('login')->with(['login_failed' => 'Email or Password is incorrect', 'email' => $email, 'previous_url' => $request->previous_url]);
    }

    public function getRegister() {
        if(Auth::check()) {
            if(!is_null(Auth::user()->email_verified_at)) {
                if(route('login') != url()->previous()) {
                    return redirect(url()->previous());
                } else {
                    return redirect('/');
                }
            } else {
                return redirect()->route('verify');
            }
        }

        $firstName = '';
        $name = '';
        /*  $firstKataName = '';
        $lastKataName = ''; */
        $birthday = '';
        $genderId = 0;
        $email = '';
        $phone = '';
        $occupationId = 0;
        $secretquestionId = 0;
        $answer = '';

        if(old('first_name')) {
            $firstName = old('first_name');
        }
        if(old('name')) {
            $name = old('name');
        }
        /*if(old('first_kata_name')) {
            $firstKataName = old('first_kata_name');
        }
        if(old('last_kata_name')) {
            $lastKataName = old('last_kata_name');
        } */
        if(old('birthday')) {
            $birthday = old('birthday');
        }
        if(old('gender_id')) {
            $genderId = old('gender_id');
        }
        if(old('email')) {
            $email = old('email');
        }
        if(old('phone')) {
            $phone = old('phone');
        }
        if(old('occupation_id')) {
            $occupationId = old('occupation_id');
        }
        if(old('secretquestion_id')) {
            $secretquestionId = old('secretquestion_id');
        }
        if(old('answer')) {
            $answer = old('answer');
        }

        $this->data['firstName'] = $firstName;
        $this->data['name'] = $name;
        /*   $this->data['firstKataName'] = $firstKataName;
        $this->data['lastKataName'] = $lastKataName; */
        $this->data['birthday'] = $birthday;
        $this->data['genderId'] = $genderId;
        $this->data['email'] = $email;
        $this->data['phone'] = $phone;
        $this->data['occupationId'] = $occupationId;
        $this->data['secretquestionId'] = $secretquestionId;
        $this->data['answer'] = $answer;

        //createNew function will check and return item, if we don't have item, it will create new item.
        $secretQuestionTag = Param::createNew(['news_type' => 'user_secret_question', 'tag_type' => 'setting']);
        $secretQuestionList = Setting::getList('', $secretQuestionTag->id);

        $occupationTag = Param::createNew(['news_type' => 'user_occupation', 'tag_type' => 'setting']);
        $occupationList = Setting::getList('', $occupationTag->id);

        $genderTag = Param::createNew(['news_type' => 'user_gender', 'tag_type' => 'setting']);
        $genderList = Setting::getList('', $genderTag->id);

        $this->data['genderList'] = $genderList;
        $this->data['secretQuestionList'] = $secretQuestionList;
        $this->data['occupationList'] = $occupationList;

        return view('auth.register')->with($this->data);
    }

    public function postRegister(RegisterRequest $request) {
        $data = array(
            'email' => $request->email,
            'password' => Hash::make($request->password),

            // 'first_name'            => $request->first_name,
            'last_name'             => $request->name,
            /* 'kata_first_name'       => $request->first_kata_name,
            'kata_last_name'        => $request->last_kata_name, */
            'birthday'              => $request->birthday,
            'gender_id'             => $request->gender_id,
            'phone'                 => $request->phone,
            // 'secret_question_id'    => $request->secretquestion_id,
            // 'occupation_id'         => $request->occupation_id,
            // 'answer'                => Hash::make($request->answer),
        );
        $user = User::create($data);

        $gender = $user->getGender;
        // $occupation = $user->getOccupation;

        $string_random = str_random(10);
        $string_random = str_replace('-', '.', $string_random);
        $string_random = str_replace('/', '.', $string_random);

        Auth::attempt(['email' => $user->email, 'password' => $request->password], true);
        $user = Auth::user();

        $data = array(
            'name' => $user->last_name,
            /* 'kataName' => $user->kata_first_name.$user->kata_last_name, */
            'birthday' => $user->birthday,
            'gender' => $gender->value,
            // 'occupation' => $occupation->value,
            'phone' => $user->phone,
            'token' => $string_random.'-'.$user->id. '-'.$user->remember_token
        );


        Mail::to($user->email)->send(new VerifyEmail($data));

        if(Mail::failures()) {
            $user->forceDelete();
            return redirect()->back()->with(['error' => 'Have error when sent verify mail']);
        }


        return redirect()->route('verify');
    }

    public function getVerify() {
        if(Auth::check()) {
            if(!is_null(Auth::user()->email_verified_at)) {
                if(route('login') != url()->previous()) {
                    return redirect(url()->previous());
                } else {
                    return redirect('/');
                }
            }
            return view('auth.verify')->with($this->data);
        } else {
            return redirect()->route('login');
        }
    }

    public function postResend() {
        if(Auth::check()) {
            if(!is_null(Auth::user()->email_verified_at)) {
                return redirect('/');
            }

            $user = Auth::user();

            $gender = $user->getGender;
            // $occupation = $user->getOccupation;

            $string_random = str_random(10);
            $string_random = str_replace('-', '.', $string_random);
            $string_random = str_replace('/', '.', $string_random);

            $data = array(
                'name' => $user->first_name.$user->last_name,
                'birthday' => $user->birthday,
                'gender' => $gender->value,
                'phone' => $user->phone,
                'token' => $string_random.'-'.$user->id. '-'.$user->remember_token
            );

            Mail::to($user->email)->send(new VerifyEmail($data));

            if(Mail::failures()) {
                return redirect()->route('verify')->with(['error' => 'Have error when sent verify mail']);
            }

            return redirect()->route('verify')->with(['resent' => 1]);
        } else {
            return redirect()->route('login');
        }
    }

    public function getActiveAccount($token) {
        $this->data['pageTitle'] = 'Verify Account';
        $this->data['pageDescription'] = 'Veriry Account Page';

        $ids = explode('-', $token);

        if(count($ids) < 3 ) {
            $this->pageTitle = 'Page Not Found';
            return view('errors.404')->with($this->data);
        }
        $id = $ids[1];
        $answer = end($ids);

        $user = User::where('id', $id)->where('remember_token', $answer)->first();

        if(is_null($user)) {
            $this->pageTitle = 'Page Not Found';
            return view('errors.404')->with($this->data);
        } else {
            if(is_null($user->email_verified_at)) {
                $user->email_verified_at = date('Y-m-d H:i:s');
                $user->save();

                $this->data['success'] = 1;

                return view('auth.verified')->with($this->data);
            }

            return redirect()->route('verify')->with(['error' => 'Have error when sent verify mail']);
        }
    }

    public function getResetPassword() {
        $this->middleware('guest');

        return view('auth.passwords.email')->with($this->data);
    }

    public function postResetPassword(Request $request) {
        $validator = Validator::make($request->all(), array(
            'email' => 'required|email|exists:users,email'
        ), array(
            'email.required' => 'Please enter your email',
            'email.email' => 'The value you enter not email',
            'email.exists' => 'Can not find any emails in record'
        ));

        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $email = $request->email;

        $resetItem = DB::table('password_resets')->where('emails', $email)->first();

        if(is_null($resetItem)) {
            $token = str_random(60);

            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $token = $resetItem->token;
        }

        $data = array(
            'token' => $user->id.$user->answer
        );

        Mail::to($email)->subject('Reset Password')->send(new ResetPassword($data));

        if(Mail::failures()) {
            return redirect()->back()->with(['error' => 'Have error when sent reset password mail']);
        }

        return redirect()->back()->with(['status' => 1]);
    }

    public function remindPassword($token) {
        $resetItem = DB::table('password_resets')->where('token', $token)->first();
    }

    public function postLogout() {
        if(Auth::check()) {
            Auth::logout();
        }

        return back();
    }
}
