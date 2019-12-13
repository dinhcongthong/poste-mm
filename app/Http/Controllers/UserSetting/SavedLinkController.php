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
use App\Models\Business;
use App\Models\User;
use App\Models\SavedLink;
use App\Models\PosteNotification;
use App\Models\Base;
use Carbon\Carbon;


class SavedLinkController extends Controller
{
    public function viewSavedLink() {

        $user_id = Auth::user()->id;

        $save_list = SavedLink::with(['getPosteTown' => function($query) {
            $query->select('id', 'name', 'slug', 'deleted_at');
        }, 'getBusiness' => function($query) {
            $query->select('id', 'name', 'slug', 'deleted_at');
        }])->where('user_id', $user_id)->orderBy('updated_at', 'DESC')->get();


        $this->data['recent_list'] = $save_list->slice(0, 3);
        $this->data['ago_list'] = $save_list->slice(3)->paginate(10);


        return view('user-setting.pages.saved-link.index')->with($this->data);
    }

    public function saveLink(Request $request) {

        $liked = 0;

        $user_id = Auth::user()->id;
        $post_id = $request->post_id;

        $post_type = $request->post_type;

        $saveLink = new SavedLink();
        $saveLink->user_id = Auth::user()->id;
        $saveLink->post_id = $post_id;
        $saveLink->post_type = $post_type;

        $saved_item = SavedLink::where('user_id', $user_id)->where('post_id', $post_id)->where('post_type', $post_type)->first();

        if(is_null($saved_item)) {
            $saveLink->save();
            $liked = 1;
        }
        else{
            $saved_item->delete();
            $liked = 0;
        }

        return response()->json([
            'result' => 1,
            'post_type' => $post_type,
            'liked' => $liked
        ]);
    }

    public function unsaveLink(Request $request) {

        $user_id = Auth::user()->id;
        $id = $request->id;

        $saveLink = new SavedLink();
        $saveLink->id;
        $saveLink->user_id = Auth::user()->id;

        $saved_link = SavedLink::where('id', $id)->where('user_id', $user_id)->first();

        if(!is_null($saved_link)) {
            $saved_link->delete();
            $unsave = 'yes';
        }
        else{
            $unsave = 'no';
        }

        return response()->json([
            'result' => 1,
            'unsave' => $unsave
        ]);

    }

    function loadDataMore(){

        $user_id = Auth::user()->id;

        $save_list = SavedLink::with(['getPosteTown' => function($query) {
            $query->select('id', 'name', 'slug', 'deleted_at');
        }, 'getBusiness' => function($query) {
            $query->select('id', 'name', 'slug', 'deleted_at');
        }])->where('user_id', $user_id)->orderBy('updated_at', 'DESC')->get();

        $save_list = $save_list->slice(3)->paginate(10);

        if($save_list->isEmpty()) {
            return response()->json([
                'result' => 0,
                'error' => 'No more data to load'
            ]);
        }

        $html = '';

        foreach ($save_list as $item) {
            if($item->post_type == 'town') {
                $name = $item->getPosteTown->name;
                $slug = $item->getPosteTown->slug;
                 $routeType = '      <a target="_blank" href="'.route("get_town_detail_route",'slug'."-".$item->post_id) .'" class="saved-item-name">';
                $routeType .=            $name;
                $routeType .= '      </a>';
            } elseif($item->post_type == 'business') {
                $name = $item->getBusiness->name;
                $slug = $item->getBusiness->slug;
                 $routeType = '      <a target="_blank" href="'.route("get_business_detail_route",'slug'."-".$item->post_id) .'" class="saved-item-name">';
                $routeType .=            $name;
                $routeType .= '      </a>';
            }

            $html .= '  <div class="saved-item saved-'.$item->post_type.'">';
            $html .= $routeType;
            $html .= '      <button type="button" class="btn btn-link text-dark unsave" style="float: inline-end;" data-id="'.$item->id.'"><i class="far fa-trash-alt"></i></button>';
            // $html .= '      <div class="saved-item-time">'.date("Y-m-d", strtotime($item->updated_at)).'</div>';
            $html .= '      <div class="saved-item-time" id="calc_time" title="'.date('Y-m-d', strtotime($item->updated_at)).'">'.\App\Models\SavedLink::timeAgo( date('Y-m-d H:i:s', strtotime($item->updated_at)) ).'</div>';
            $html .= '  </div>';
        }

        return response()->json([
            'result' => 1,
            'html' => $html,
            'total_page' => $save_list->lastPage()
        ]);

    }

}
