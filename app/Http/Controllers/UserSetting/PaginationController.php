<?php

namespace App\Http\Controllers\UserSetting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;
use DB;

use App\Http\Requests\FeedbackRequest;

use App\Mail\Feedback\OwnerMail as FeedbackOwnerMail;
use App\Mail\Feedback\UserMail as FeedbackUserMail;
use App\Models\PosteTown;
use App\Models\SavedLink;


class PaginationController extends Controller
{
    function all_saved_link(Request $request){
        $user_id = Auth::user()->id;

        if($request->ajax()){

            $data = SavedLink::with(['getPosteTown', 'getBusiness'])->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(7);

            return view('user-setting.pages.saved-link.pagination', compact('data'));
        } 
    }

    function fetch_data(Request $request){
    	$user_id = Auth::user()->id;

        if($request->ajax()){
            $data = SavedLink::with(['getPosteTown', 'getBusiness'])->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(7);
            return view('user-setting.pages.saved-link.pagination_data', compact('data'))->render();
        }
    }
}