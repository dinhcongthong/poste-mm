<?php

namespace App\Http\Controllers\UserSetting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\Base;
use App\Http\Requests\EditUserRequest;
use App\Models\PosteTown;
use App\Models\PosteNotification;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function getEdit() {

        $user = User::with(['getThumb'])->withTrashed()->find(Auth::user()->id);
        $thumb_url = '';
        if(!is_null($user->getThumb)) {
            $thumb_url = Base::getUploadURL($user->getThumb->name, $user->getThumb->dir);
        } else {
            $thumb_url = '';
        }
        $this->data['thumb_url'] = $thumb_url;
        return view('user-setting.pages.user-profile.index')->with($this->data);
    }
    // edit info user
    public function postEdit(EditUserRequest $request) {
        $user = Auth::user();
        $user->first_name = NULL;
        $user->last_name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->password = Hash::make($request->input('password'));
        $user->gender_id = $request->input('gender_id');
        $user->birthday = $request->input('birthday');
        $user->save();
        return redirect()->route('get_user_setting_index_route')->with(array(
            'update_success' => 1
        ));
    }
}
