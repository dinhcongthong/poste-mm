<?php

namespace App\Http\Controllers\UserSetting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Models\JobSearching;
use App\Models\PosteTown;
use App\Models\PosteNotification;

class JobSearchingController extends Controller
{
    public function postDelete(Request $request) {
        if (!Auth::check()) {
            return response()->json([
                'result' => 0,
                'error' => 'You must login!!!!'
                ]
            );
        }

        $id = $request->id;

        $result = JobSearching::deleteItem($id);

        if ($result['result']) {
            $articleList = JobSearching::withTrashed()->where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->paginate(3);

            $view = view('user-setting.pages.home.index')->with(['articleList' => $articleList])->render();

            return response()->json([
                'result' => 1,
                'view' => $view
                ]);
            }

            return response()->json($result);
        }
    }
