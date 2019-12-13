<?php

namespace App\Http\Controllers\UserSetting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ImageFactory;
use App\Models\Param;
use App\Models\Gallery;
use App\Models\Base;

use File;
use Validator;
use Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\PosteNotification;
use App\Models\PosteTown;
use App\Models\Business;

class HomeController extends Controller
{

    public function index() {
        // get notify list
        // return $this->data['notify_list'];
        if(Session::has('update_success')) {
            $this->data['update_success'] = 1; // check update user
        }

        if (Session::has('checkAvatar')) {
            $this->data['checkAvatar'] = 1;
            session()->forget('checkAvatar');
        }
        return view('user-setting.pages.home.index')->with($this->data);
    }

    public function changePassword(Request $request) {
        $user = Auth::user();
        $rules = array(
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return response()->json([
                'result' => -1,
                'errors' => $validator->errors()->all()
            ]);
        } else {
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return 1;
        }
    }

    // update subcribe
    public function updateSucribe (Request $request) {
        $user = Auth::user();
        if (Auth::user()->is_news_letter == 1) {
            $user->is_news_letter = 0;
            $user->save();
            return 0;
        }
        else {
            $user->is_news_letter = 1;
            $user->save();
            return 1;
        }
        return 2;
    }
    // upload avata
    public function uploadAvatar (Request $request) {
        $rules = array(
            'avatar' => 'required|image|max:4097|dimensions:min_width=300',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->getMessages()], 400);
        }
        else {
            $galleryId = 0;
            $file = $request->avatar;

            if (!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'user-profile', 'image', 'thumb');
                $galleryId = $gallery_id_arr[0];
                $user = Auth::user();

                if($user->thumb_id != 0) {
                    Gallery::clearGallery($user->thumb_id, 'user', $user->id);
                }

                $user->thumb_id = $galleryId;

                $user->save();
            }
            $this->data['image_upload'] = 1;
            session(['checkAvatar' => 1]);
            return redirect()->route('get_user_setting_index_route');
        };
    }

    // get notification
    public function getNotification (Request $request) {
        //get update notify
        $user_id = Auth::user()->id;
        $this->data['notify_paginate'] = PosteNotification::with(['getPosteTown', 'getBusinesses'])->where('owner_id', $user_id)->orderBy('created_at', 'desc')->paginate(10);

        return view('user-setting.pages.home.notifications')->with($this->data);
    }

    // post detail notification
    public function getDetailNotification ($notifyId) {
        // handle
        $notify = PosteNotification::find($notifyId);
        $update = $notify->update(['status' => 1]);

        if ($update) {
            $this->data['notify'] = $notify;
            return view('user-setting.pages.home.detail-notification')->with($this->data);
        }
    }

    // post read all notification
    public function postReadAllNotification () {
        $owner_id = Auth::user()->id;

        $readAll = PosteNotification::where('owner_id', $owner_id)->update(['status' => 1]);
        if ($readAll) {
            return 1;
        }
        return 0;
    }

    // post delete notification
    public function deleteNotification (Request $request) {
        $id = $request->id;

        $deleteNotify = PosteNotification::find($id);
        $result = $deleteNotify->delete();
        if ($result) {
            return 1;
        }
        return 0;
    }

    // update status notifications
    public function notifyStatus (Request $request) {
        $id = $request->id;
        $result = '';
        $statusUpdate = PosteNotification::find($id);
        if ($statusUpdate->status == 0) {
            $result = $statusUpdate->update(['status' => 1]);
        }
        else {
            $result = $statusUpdate->update(['status' => 0]);
        }
        if ($result) {
            return 1;
        }
        return 0;
    }

}
