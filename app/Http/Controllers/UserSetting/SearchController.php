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
use App\Models\User;
use App\Models\SavedLink;
use App\Models\PosteNotification;
use App\Models\Base;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;


class SearchController extends Controller
{
 	public function autoDropDownSavedLink(Request $request){
 		// return '123';
 		$user_id = Auth::user()->id;
        $post_id = $request->post_id;

        // $nameLink = Input::get('name_post');
        // $nameLink = $_GET['name_post'];

        $dataSearch = SavedLink::with(
        	[
        		'getPosteTown' => function($town) {  $town->select('id', 'name', 'slug');  }, 
        		'getBusiness' => function($business) {  $business->select('id', 'name', 'slug');  }, 
    		])
	    	->whereHas('getPosteTown', function($t){
    			$nameLink = Input::get('name_post');
	    		$t->select('name');
	    		$t->where('name', 'like', '%'.$nameLink.'%');
	    	})
	    	->orwhereHas('getBusiness', function($b){
	    		$nameLink = Input::get('name_post');
	    		$b->select('name');
	    		$b->where('name', 'like', '%'.$nameLink.'%');
	    	})
	    	->where('user_id', $user_id)
    	->get();

		$html = '';

        foreach ($dataSearch as $search_item) {
            if($search_item->post_type == 'town') {
                $name = $search_item->getPosteTown->name;
                $slug = $search_item->getPosteTown->slug;
                $routeType = '      <a target="_blank" href="'.route("get_town_detail_route",'slug'."-".$search_item->post_id) .'" class="saved-item-name">';
	            $routeType .=            $name;
	            $routeType .= '      </a>';
            } elseif($search_item->post_type == 'business') {
                $name = $search_item->getBusiness->name;
                $slug = $search_item->getBusiness->slug;
                $routeType = '      <a target="_blank" href="'.route("get_business_detail_route",'slug'."-".$search_item->post_id) .'" class="saved-item-name">';
	            $routeType .=            $name;
	            $routeType .= '      </a>';
            }

            $html .= '  <div class="saved-item saved-'.$search_item->post_type.'" style="z-index: 5;" >';
            $html .= $routeType;
            $html .= '      <button type="button" class="btn btn-link text-dark unsave" style="float: inline-end;" data-id="'.$search_item->id.'"><i class="far fa-trash-alt"></i></button>';
            $html .= '      <div class="saved-item-time">'.date("Y-m-d", strtotime($search_item->updated_at)).'</div>';
            $html .= '  </div>';
        }

        echo $html;

    }

}

// with(['getPosteTown','getBusiness'])->