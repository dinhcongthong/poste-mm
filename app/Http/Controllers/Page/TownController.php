<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;

use App\Http\Requests\PosteTown\TownBasicInfoRequest;
use App\Http\Requests\PosteTown\MenuFormRequest;
use App\Http\Requests\PosteTown\GalleryRequest;
use App\Http\Requests\PosteTown\PDFRequest;
use App\Http\Requests\PosteTown\TownGalleryRequest;
use App\Http\Requests\FeedbackRequest;

use App\Mail\Feedback\OwnerMail as FeedbackOwnerMail;
use App\Mail\Feedback\UserMail as FeedbackUserMail;

use App\Models\Setting;
use App\Models\City;
use App\Models\Gallery;
use App\Models\TownGallery;
use App\Models\ImageFactory;
use App\Models\Base;
use App\Models\Param;
use App\Models\PosteTown;
use App\Models\Category;
use App\Models\TownMenu;
use App\Models\TownMenuDetail;
use App\Models\TownPDFMenu;
use App\Models\TownRegClose;
use App\Models\TownTag;
use App\Models\User;
use App\Models\News;
use App\Models\SavedLink;
use App\Models\PosteNotification;

class TownController extends Controller
{
    public function __construct() {
        parent::__construct();

        // Delete resources not save of users...
        $gallery_list = TownGallery::where('town_id', 0)->whereDate('created_at', '<=', date('Y-m-d', strtotime('-7 days')))->get();

        foreach($gallery_list as $item) {
            TownGallery::deleteItem($item->id);
        }

        $pdf_list = TownPDFMenu::where('town_id', 0)->whereDate('created_at', '<=', date('Y-m-d', strtotime('-7 days')))->get();
        foreach($pdf_list as $item) {
            TownPDFMenu::deletePDF($item->id);
        }

        // $town_regular_closing_list = TownRegClose::whereDate('end_date', '<', date('Y-m-d'))->get();
        // foreach($town_regular_closing_list as $item) {
        //     $item->delete();
        // }
    }

    public function index(Request $request) {
        $category_id = -1;

        if(is_null($request->search_category) && is_null($request->keywords)) {

            $premium_list= PosteTown::with(['getThumbnail', 'getCity', 'getCategory'])->whereDate('end_free_date', '>=', date('Y-m-d'))->orWhere(function($q) {
                $q->where('fee', 1)->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'));
            })->inRandomOrder()->paginate(12);

            $category_id = 0;
            $town_list = $premium_list;

        } else {
            $premium_list= PosteTown::with(['getThumbnail', 'getCity', 'getCategory'])->whereDate('end_free_date', '>=', date('Y-m-d'))->orWhere(function($q) {
                $q->where('fee', 1)->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'));
            });
            $normal_list = PosteTown::with(['getThumbnail', 'getCity', 'getCategory']);

            if(!is_null($request->search_category) && $request->search_category != 0) {
                $premium_list = $premium_list->where('category_id', $request->search_category);
                $normal_list = $normal_list->where('category_id', $request->search_category);

                $category_id = $request->search_category;
            }


            if(!is_null($request->keywords) && $request->keywords != '') {
                $premium_list = $premium_list->where('name', 'LIKE', '%'.$request->keywords.'%');
                $normal_list = $normal_list->where('name', 'LIKE', '%'.$request->keywords.'%');
            }
            $premium_list = $premium_list->inRandomOrder()->get();
            $normal_list = $normal_list->whereNotIn('id', $premium_list->pluck('id')->toArray())->inRandomOrder()->get();
            $town_list = $premium_list->merge($normal_list)->paginate(12);
        }

        $this->loadPageInfoFromChild('poste-town', 'category', 0);
        $this->data['town_list'] = $town_list;
        $this->data['category_id'] = $category_id;

        return view('www.pages.town.index')->with($this->data);
    }

    public function category($category) {
        $smallest_date = date('Y-m-d', strtotime('-30 days'));

        $key = strrpos($category, '-');
        $slug = substr($category, 0, $key);
        $category_id = substr($category, $key + 1);

        $category = Category::find($category_id);
        if(is_null($category)) {
            $this->pageTitle = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
            return view('errors.404')->with($this->data);
        }

        if($slug != $category->slug) {
            return redirect()->route('get_town_category_route', $category->slug.'-'.$category->id);
        }


        $premium_list= PosteTown::with(['getThumbnail', 'getCity', 'getCategory'])->where('category_id', $category_id)->where(function($que) {
            $que->whereDate('end_free_date', '>=', date('Y-m-d'))->orWhere(function($q) {
                $q->where('fee', 1)->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'));
            });
        })->inRandomOrder()->get();
        $normal_list = PosteTown::with(['getThumbnail', 'getCity', 'getCategory'])->where('category_id', $category_id)->whereNotIn('id', $premium_list->pluck('id')->toArray())->inRandomOrder()->get();

        $town_list = $premium_list->merge($normal_list)->paginate(12);

        $this->data['town_list'] = $town_list;
        $this->data['smallest_date'] = $smallest_date;
        $this->data['category_id'] = $category_id;

        $this->loadPageInfoFromChild('poste-town', 'category', $category_id);

        return view('www.pages.town.index')->with($this->data);
    }

    public function tag($tag) {
        $smallest_date = date('Y-m-d', strtotime('-30 days'));

        $key = strrpos($tag, '-');
        $slug = substr($tag, 0, $key);
        $tag_id = substr($tag, $key + 1);

        $tag_item = Category::where('parent_id', '<>', 0)->where('id', $tag_id)->first();

        if(is_null($tag_item)) {
            $this->pageTitle = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
            return view('errors.404')->with($this->data);
        }

        if($tag_item->slug != $slug) {
            return redirect()->route('get_town_tag_route', $tag_item->slug.'-'.$tag_item->id);
        }

        $town_list = PosteTown::with(['getThumbnail', 'getCity', 'getCategory', 'getTagList'])->whereHas('getTagList', function($query) use($tag_id) {
            $query->where('tag_id', $tag_id);
        })->orderBy('fee', 'DESC')->orderBy('created_at', 'DESC')->paginate(12);

        $this->data['town_list'] = $town_list;
        $this->data['smallest_date'] = $smallest_date;
        $this->data['tag_id'] = $tag_id;
        $this->data['category_id'] = Category::with('getParentCategory')->find($tag_id)->getParentCategory->id;

        $this->loadPageInfoFromChild('poste-town', 'tag', $tag);

        return view('www.pages.town.index')->with($this->data);
    }

    public function detail($detail, Request $request) {
        // Set to check and set data for body tag
        $this->data['scrollspy'] = 1;

        $key = strrpos($detail, '-');
        $slug = substr($detail, 0, $key);
        $detail_id = substr($detail, $key + 1);

        $article = PosteTown::with(['getThumbnail', 'getCategory.getIcon', 'getTagList'])->find($detail_id);

        if(is_null($article)) {
            $this->pageTitle = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
            return view('errors.404')->with($this->data);
        }

        if($article->slug != $slug) {
            return redirect()->route('get_town_detail_route', $article->slug.'-'.$article->id);
        }

        if(!in_array($article->category_id, array(70, 74))) {
            $menuList = TownMenu::with(['getDetail.getImage'])->where('town_id', $article->id)->orderBy('id', 'ASC')->get();
            $pdf_list = TownPDFMenu::where('town_id', $article->id)->get();

            $this->data['menuList'] = $menuList;
            $this->data['pdf_list'] = $pdf_list;
        }

        $promotion_list = [];
        if($article->customer_id != 0) {
            $tag = Param::getExactParamItem('dailyinfo', 'article');

            $promotion_list = News::with(['getThumbnail'])->whereHas('getCategoryNews', function($query) {
                $query->where('category_id', 5)->orWhere('category_id', 6);
            })->where('customer_id', $article->customer_id)->where('tag', $tag->id)->whereDate('published_at', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->orderBy('id', 'DESC')->get();
        }

        $space_images = TownGallery::where('album_id', 1)->where('town_id', $article->id)->orderBy('id', 'DESC')->get();
        $food_images = TownGallery::where('album_id', 2)->where('town_id', $article->id)->orderBy('id', 'DESC')->get();
        $menu_images = TownGallery::where('album_id', 3)->where('town_id', $article->id)->orderBy('id', 'DESC')->get();
        $general_images = TownGallery::where('album_id', 4)->where('town_id', $article->id)->orderBy('id', 'DESC')->get();

        $private_room_list = Setting::getSettingListFromParam('private-room');
        $usage_scenes_list = Setting::getSettingListFromParam('restaurant-usage-scenes');
        $service_tax_list = Setting::getSettingListFromParam('service-tax');
        $language_list = Setting::getSettingListFromParam('language');

        $closing_date = TownRegClose::whereDate('start_date', '<=', date('Y-m-d'))->orWhere('end_date', '>=', date('Y-m-d'))->first();
        $working_time = '0';
        $time_in_week = '';


        if(is_null($closing_date)) {
            $this->setWorkingTime($article);

            $time_in_week = $this->getTimeInWeek($article);
        } else {
            if($closing_date->start_date != $closing_date->end_date) {
                $time_in_week = date('m-d-Y', strtotime($closing_date->start_date)) . ' - ' . date('m-d-Y', strtotime($closing_date->end_date));
            } else {
                $time_in_week = date('m-d-Y', strtotime($closing_date->start_date));
            }
        }

        $this->data['article'] = $article;
        $this->data['private_room_list'] = $private_room_list;
        $this->data['usage_scenes_list'] = $usage_scenes_list;
        $this->data['service_tax_list'] = $service_tax_list;
        $this->data['language_list'] = $language_list;
        $this->data['time_in_week'] = $time_in_week;
        $this->data['closing_date'] = $closing_date;

        $this->data['space_images'] = $space_images;
        $this->data['food_images'] = $food_images;
        $this->data['menu_images'] = $menu_images;
        $this->data['general_images'] = $general_images;
        $this->data['promotion_list'] = $promotion_list;

        $this->loadPageInfoFromChild('poste-town', '', $article);

        // -----------------------------------
        // Check Save Link
        $liked = 0;
        if(Auth::check()){
            $user_id = Auth::user()->id;

            $post_type = 'town';

            $saved_item = SavedLink::where('user_id', $user_id)->where('post_id', $detail_id)->where('post_type', $post_type)->first();

            if(!is_null($saved_item)) {
                $liked = 1;
            }
        }

        $this->data['liked'] = $liked;

        return view('www.pages.town.detail.detail')->with($this->data);
    }

    // Post Save FeedBack
    public function postSaveFeedback(FeedbackRequest $request) {
        $town_item = PosteTown::find($request->post_id);
        $result = false;

        if(!is_null($town_item)) {

            $owner_id = $town_item->owner_id;

            if(!is_null($town_item->getOwner)) {
                $owner_email = $town_item->getOwner->email;
            } else {
                $owner_email = $town_item->getUser->email;
            }
            $user_name = $request->name;
            $post_id = $request->post_id;
            $post_type = 'town';
            $content = $request->content;
            $user_email = $request->email;
            $user_subject = $request->subject;

            $url = route('get_town_detail_route', $town_item->slug.'-'.$town_item->id);

            $subject = '[Poste Myanmar] Poste Town Feedback...';
            Mail::to($user_email)
            ->send(new FeedbackUserMail($subject, $town_item->name, $url, $content));

            if(!Mail::failures()) {
                $data = array(
                    'email' => $user_email,
                    'post_id' => $post_id,
                    'owner_id' => $owner_id,
                    'content' => $content,
                    'post_type' => $post_type,
                    'name' => $user_name,
                    'type_id' => PosteNotification::TYPE_FEEDBACK
                );

                $feedback_item = PosteNotification::create($data);

                if($feedback_item) {
                    $subject = '[Poste Myanmar] '.$user_subject;

                    Mail::to($owner_email)
                    ->bcc('marketing-mm@poste-vn.com')
                    // ->bcc('thong@poste-vn.com')
                    ->send(new FeedbackOwnerMail($subject, $url, $user_email, $content));

                    $result = true;
                }
            }
        }

        if($result) {
            return response()->json([
                'result' => 1
            ]);
        }

        return response()->json([
            'result' => 0
        ]);
    }

    public function setWorkingTime($article) {
        $d = date('w');
        $current_hour = date('H:i');
        $start_working_time = '';
        $end_working_time = '';
        $working_time = [];

        switch ($d) {
            case 0: {
                $prev_time = $article->saturday;
                $today_time = $article->sunday;
                break;
            }
            case 1: {
                $prev_time = $article->sunday;
                $today_time = $article->monday;
                break;
            }
            case 2: {
                $prev_time = $article->monday;
                $today_time = $article->tuesday;
                break;
            }
            case 3: {
                $prev_time = $article->tuesday;
                $today_time = $article->wednessday;
                break;
            }
            case 4: {
                $prev_time = $article->wednessday;
                $today_time = $article->thursday;
                break;
            }
            case 5: {
                $prev_time = $article->thursday;
                $today_time = $article->friday;
                break;
            }
            case 6: {
                $prev_time = $article->friday;
                $today_time = $article->saturday;
                break;
            }
        }

        $working_time = explode('-', $prev_time);
        if($working_time[0] == 1) {
            $start_hours = explode(',', $working_time[1]);
            $end_hours = explode(',', $working_time[2]);

            foreach($end_hours as $key => $value) {
                if($value == '00:00') {
                    $end_hours[$key] = '24:00';
                }
            }

            /* Check working time yesterday to today morning */
            if(count($start_hours) > 1) {
                if($start_hours[1] > $end_hours[1]) {
                    if($current_hour < $end_hours[1]) {
                        $start_working_time = '00:00';
                        $end_working_time = $end_hours[1];
                    }
                }
            } else {
                if($start_hours[0] > $end_hours[0]) {
                    if($current_hour < $end_hours[0]) {
                        $start_working_time = '00:00';
                        $end_working_time = $end_hours[0];
                    }
                }
            }
        }

        if(empty($start_working_time)) {
            // Check Today
            $working_time = explode('-', $today_time);

            if($working_time[0] == 1) {
                $start_hours = explode(',', $working_time[1]);
                $end_hours = explode(',', $working_time[2]);

                foreach($end_hours as $key => $value) {
                    if($value == '00:00') {
                        $end_hours[$key] = '24:00';
                    }

                    if($end_hours[$key] < $start_hours[$key]) {
                        $end_hours[$key] = '24:00';
                    }
                }

                $start_working_time = $start_hours[0];
                $end_working_time = $end_hours[0];

                if(count($start_hours) > 1 && $current_hour > $end_hours[0]) {
                    $start_working_time = $start_hours[1];
                    $end_working_time = $end_hours[1];
                }
            }
        }

        $this->data['working_time'] = $working_time;
        $this->data['start_working_time'] = $start_working_time;
        $this->data['end_working_time'] = $end_working_time;
    }

    public function getTimeInWeek($article) {
        $time_in_week = "<div class='row'>";
        $current_day = date('w');
        $check_loop = 1;
        while($check_loop < 8) {
            $day_data = '';
            $hour_data = '';
            $class_data = '';

            switch ($check_loop) {
                case 7: {
                    $working_time = explode('-', $article->sunday);

                    $day_data = 'Sunday';

                    if($working_time[0] == 1) {
                        $start_hours = explode(',', $working_time[1]);
                        $end_hours = explode(',', $working_time[2]);

                        $hour_data = $start_hours[0] . ' - ' . ($end_hours[0] == '00:00' ? '24:00' : $end_hours[0]);

                        if(count($start_hours) > 1) {
                            $hour_data .= "<br/>".$start_hours[1] . ' - ' . ($end_hours[1] == '00:00' ? '24:00' : $end_hours[1]);
                        }
                    } else {
                        $hour_data = 'Close';
                        $class_data = 'text-warning';
                    }

                    if($current_day == 0) {
                        $class_data = 'today';
                    }
                    break;
                }
                case 1: {
                    $working_time = explode('-', $article->monday);

                    $day_data = 'Monday';

                    if($working_time[0] == 1) {
                        $start_hours = explode(',', $working_time[1]);
                        $end_hours = explode(',', $working_time[2]);

                        $hour_data = $start_hours[0] . ' - ' . ($end_hours[0] == '00:00' ? '24:00' : $end_hours[0]);

                        if(count($start_hours) > 1) {
                            $hour_data .= "<br/>".$start_hours[1] . ' - ' . ($end_hours[1] == '00:00' ? '24:00' : $end_hours[1]);
                        }
                    } else {
                        $hour_data = 'Close';
                        $class_data = 'text-warning';
                    }

                    if($current_day == 1) {
                        $class_data = 'today';
                    }
                    break;
                }
                case 2: {
                    $working_time = explode('-', $article->tuesday);

                    $day_data = 'Tuesday';

                    if($working_time[0] == 1) {
                        $start_hours = explode(',', $working_time[1]);
                        $end_hours = explode(',', $working_time[2]);

                        $hour_data = $start_hours[0] . ' - ' . ($end_hours[0] == '00:00' ? '24:00' : $end_hours[0]);

                        if(count($start_hours) > 1) {
                            $hour_data .= "<br/>".$start_hours[1] . ' - ' . ($end_hours[1] == '00:00' ? '24:00' : $end_hours[1]);
                        }
                    } else {
                        $hour_data = 'Close';
                        $class_data = 'text-warning';
                    }

                    if($current_day == 2) {
                        $class_data = 'today';
                    }
                    break;
                }
                case 3: {
                    $working_time = explode('-', $article->wednessday);

                    $day_data = 'Wednessday';

                    if($working_time[0] == 1) {
                        $start_hours = explode(',', $working_time[1]);
                        $end_hours = explode(',', $working_time[2]);

                        $hour_data = $start_hours[0] . ' - ' . ($end_hours[0] == '00:00' ? '24:00' : $end_hours[0]);

                        if(count($start_hours) > 1) {
                            $hour_data .= "<br/>".$start_hours[1] . ' - ' . ($end_hours[1] == '00:00' ? '24:00' : $end_hours[1]);
                        }
                    } else {
                        $hour_data = 'Close';
                        $class_data = 'text-warning';
                    }

                    if($current_day == 3) {
                        $class_data = 'today';
                    }
                    break;
                }
                case 4: {
                    $working_time = explode('-', $article->thursday);

                    $day_data = 'Thursday';

                    if($working_time[0] == 1) {
                        $start_hours = explode(',', $working_time[1]);
                        $end_hours = explode(',', $working_time[2]);

                        $hour_data = $start_hours[0] . ' - ' . ($end_hours[0] == '00:00' ? '24:00' : $end_hours[0]);

                        if(count($start_hours) > 1) {
                            $hour_data .= "<br/>".$start_hours[1] . ' - ' . ($end_hours[1] == '00:00' ? '24:00' : $end_hours[1]);
                        }
                    } else {
                        $hour_data = 'Close';
                        $class_data = 'text-warning';
                    }

                    if($current_day == 4) {
                        $class_data = 'today';
                    }
                    break;
                }
                case 5: {
                    $working_time = explode('-', $article->friday);

                    $day_data = 'Friday';

                    if($working_time[0] == 1) {
                        $start_hours = explode(',', $working_time[1]);
                        $end_hours = explode(',', $working_time[2]);

                        $hour_data = $start_hours[0] . ' - ' . ($end_hours[0] == '00:00' ? '24:00' : $end_hours[0]);

                        if(count($start_hours) > 1) {
                            $hour_data .= "<br/>".$start_hours[1] . ' - ' . ($end_hours[1] == '00:00' ? '24:00' : $end_hours[1]);
                        }
                    } else {
                        $hour_data = 'Close';
                        $class_data = 'text-warning';
                    }

                    if($current_day == 5) {
                        $class_data = 'today';
                    }
                    break;
                }
                case 6: {
                    $working_time = explode('-', $article->saturday);

                    $day_data = 'Saturday';

                    if($working_time[0] == 1) {
                        $start_hours = explode(',', $working_time[1]);
                        $end_hours = explode(',', $working_time[2]);

                        $hour_data = $start_hours[0] . ' - ' . ($end_hours[0] == '00:00' ? '24:00' : $end_hours[0]);

                        if(count($start_hours) > 1) {
                            $hour_data .= "<br/>".$start_hours[1] . ' - ' . ($end_hours[1] == '00:00' ? '24:00' : $end_hours[1]);
                        }
                    } else {
                        $hour_data = 'Close';
                        $class_data = 'text-warning';
                    }

                    if($current_day == 6) {
                        $class_data = 'today';
                    }
                    break;
                }
            }

            $time_in_week .= "<div class='col-5 mb-2 font-weight-bold ".$class_data."'>".$day_data."</div><div class='col-7 mb-2 ".$class_data."'>".$hour_data."</div>";
            $check_loop++;
        }
        $time_in_week .= "<div>";

        return $time_in_week;
    }

    // Add New Area
    public function getNew(Request $request) {
        if(!isset($request->category)) {
            return view('www.pages.town.update.step1')->with($this->data);
        }

        // Set to check and set data for body tag
        $this->data['scrollspy'] = 1;

        $category = explode('-', $request->category);
        $category_id = end($category);

        $category_list = Category::getCategoryListFromParam('poste-town');
        $category_id_list = $category_list->pluck('id')->toArray();

        $category_item = $category_list->where('id', $category_id)->first();

        if(!in_array($category_id, $category_id_list)) {
            $this->data['pageTitle'] = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            return view('errors.404')->with($this->data);
        }

        $name = '';
        // $tags = '';
        $address = '';
        $city_id = 0;
        $description = '';
        $route_guide = '';
        $email = '';
        $website = '';
        $facebook = '';
        $credit = [];
        $phone = '';
        $avatar = '';
        $map = '';
        // $regular_close = '';
        $article_tags = [];

        $this->data['avatar'] = $avatar;
        $this->data['name'] = $name;
        // $this->data['tags'] = $tags;
        $this->data['address'] = $address;
        $this->data['city_id'] = $city_id;
        $this->data['description'] = $description;
        $this->data['route_guide'] = $route_guide;
        $this->data['email'] = $email;
        $this->data['website'] = $website;
        $this->data['facebook'] = $facebook;
        $this->data['credit'] = $credit;
        $this->data['phone'] = $phone;
        $this->data['map'] = $map;
        // $this->data['regular_close'] = $regular_close;
        $this->data['article_tags'] = $article_tags;


        $space_images = [];
        $food_images = [];
        $menu_images = [];
        $general_images = [];

        $this->data['space_images'] = $space_images;
        $this->data['food_images'] = $food_images;
        $this->data['menu_images'] = $menu_images;
        $this->data['general_images'] = $general_images;

        switch($category_id) {
            case 68: {
                $working_time = '';
                $budget = '';
                $private_room = ['-1'];
                $smoking = '-1';
                $currency = [];
                $wifi = '-1';
                $usage_scenes = [];
                $service_tax = 0;
                $parking = '-1';

                $this->data['working_time'] = $working_time;
                $this->data['budget'] = $budget;
                $this->data['private_room'] = $private_room;
                $this->data['smoking'] = $smoking;
                $this->data['currency'] = $currency;
                $this->data['wifi'] = $wifi;
                $this->data['usage_scenes'] = $usage_scenes;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;

                $currency_list = Setting::getSettingListFromParam('currency');
                $service_tax_list = Setting::getSettingListFromParam('service-tax');
                $usage_scene_list = Setting::getSettingListFromParam('restaurant-usage-scenes');
                $private_room_list = Setting::getSettingListFromParam('private-room');
                $menu_list = [];
                $pdf_menu_list = [];

                $this->data['currency_list'] = $currency_list;
                $this->data['service_tax_list'] = $service_tax_list;
                $this->data['usage_scene_list'] = $usage_scene_list;
                $this->data['private_room_list'] = $private_room_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 69: {
                $working_time = '';
                $currency = [];

                $smoking = '-1';
                $wifi = '-1';
                $service_tax = 0;
                $parking = '-1';

                $this->data['working_time'] = $working_time;
                $this->data['currency'] = $currency;

                $this->data['wifi'] = $wifi;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;
                $this->data['smoking'] = $smoking;

                $currency_list = Setting::getSettingListFromParam('currency');
                $service_tax_list = Setting::getSettingListFromParam('service-tax');
                $menu_list = [];
                $pdf_menu_list = [];

                $this->data['currency_list'] = $currency_list;
                $this->data['service_tax_list'] = $service_tax_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 70: {
                $budget = '';
                $check_in = '';
                $check_out = '';
                $laundry = '-1';
                $breakfast = '-1';
                $shuttle = -1;
                $air_condition = -1;
                $wifi = '-1';
                $parking = '-1';
                $kitchen = -1;
                $tv = -1;
                $shower = -1;
                $bathtub = -1;
                $luggage = -1;
                $currency = [];

                $this->data['budget'] = $budget;
                $this->data['check_in'] = $check_in;
                $this->data['check_out'] = $check_out;
                $this->data['laundry'] = $laundry;
                $this->data['breakfast'] = $breakfast;
                $this->data['shuttle'] = $shuttle;
                $this->data['air_condition'] = $air_condition;
                $this->data['wifi'] = $wifi;
                $this->data['parking'] = $parking;
                $this->data['kitchen'] = $kitchen;
                $this->data['tv'] = $tv;
                $this->data['shower'] = $shower;
                $this->data['bathtub'] = $bathtub;
                $this->data['luggage'] = $luggage;
                $this->data['currency'] = $currency;

                $currency_list = Setting::getSettingListFromParam('currency');

                $this->data['currency_list'] = $currency_list;

                break;
            }
            case 71: {
                $smoking = '-1';
                $wifi = '-1';
                $service_tax = 0;
                $parking = '-1';
                $working_time = '';
                $budget = '';
                $currency = [];

                $this->data['wifi'] = $wifi;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;
                $this->data['smoking'] = $smoking;
                $this->data['working_time'] = $working_time;
                $this->data['budget'] = $budget;
                $this->data['currency'] = $currency;

                $currency_list = Setting::getSettingListFromParam('currency');
                $service_tax_list = Setting::getSettingListFromParam('service-tax');
                $menu_list = [];
                $pdf_menu_list = [];

                $this->data['currency_list'] = $currency_list;
                $this->data['service_tax_list'] = $service_tax_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 72: {
                $working_time = '';
                $budget = '';
                $currency = [];
                $wifi = '-1';
                $parking = '-1';

                $this->data['working_time'] = $working_time;
                $this->data['budget'] = $budget;
                $this->data['currency'] = $currency;
                $this->data['wifi'] = $wifi;
                $this->data['parking'] = $parking;

                $currency_list = Setting::getSettingListFromParam('currency');
                $menu_list = [];
                $pdf_menu_list = [];

                $this->data['currency_list'] = $currency_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 73: {
                $working_time = '';
                $budget = '';
                $currency = [];

                $this->data['working_time'] = $working_time;
                $this->data['budget'] = $budget;
                $this->data['currency'] = $currency;

                $currency_list = Setting::getSettingListFromParam('currency');
                $menu_list = [];
                $pdf_menu_list = [];

                $this->data['currency_list'] = $currency_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 74: {
                $working_time = '';
                $insurance = -1;
                $language = [];
                $fee_rate = '';
                $department = '';
                $wifi = '-1';
                $parking = '-1';
                $service_tax = 0;

                $this->data['working_time'] = $working_time;
                $this->data['insurance'] = $insurance;
                $this->data['language'] = $language;
                $this->data['fee_rate'] = $fee_rate;
                $this->data['department'] = $department;
                $this->data['wifi'] = $wifi;
                $this->data['parking'] = $parking;
                $this->data['service_tax'] = $service_tax;

                $language_list = Setting::getSettingListFromParam('language');
                $service_tax_list = Setting::getSettingListFromParam('service-tax');

                $this->data['language_list'] = $language_list;
                $this->data['service_tax_list'] = $service_tax_list;

                break;
            }
            case 75: {
                $working_time = '';
                $currency = [];

                $smoking = '-1';
                $wifi = '-1';
                $service_tax = 0;
                $parking = '-1';

                $this->data['working_time'] = $working_time;
                $this->data['currency'] = $currency;

                $this->data['wifi'] = $wifi;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;
                $this->data['smoking'] = $smoking;

                $currency_list = Setting::getSettingListFromParam('currency');
                $service_tax_list = Setting::getSettingListFromParam('service-tax');
                $menu_list = [];
                $pdf_menu_list = [];

                $this->data['currency_list'] = $currency_list;
                $this->data['service_tax_list'] = $service_tax_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 76: {
                $working_time = '-1';
                $currency = [];
                $target_student = '';
                $smoking = '-1';
                $wifi = '-1';
                $service_tax = 0;
                $parking = '-1';

                $this->data['currency'] = $currency;
                $this->data['working_time'] = $working_time;
                $this->data['target_student'] = $target_student;
                $this->data['wifi'] = $wifi;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;
                $this->data['smoking'] = $smoking;

                $menu_list = [];
                $pdf_menu_list = [];
                $service_tax_list = Setting::getSettingListFromParam('service-tax');
                $currency_list = Setting::getSettingListFromParam('currency');

                $this->data['currency_list'] = $currency_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;
                $this->data['service_tax_list'] = $service_tax_list;

                break;
            }
            case 77: {
                $working_time = '';
                $object = '';
                $tuition_fee = '';
                $smoking = '-1';
                $wifi = '-1';
                $service_tax = 0;
                $parking = '-1';

                $this->data['working_time'] = $working_time;
                $this->data['object'] = $object;
                $this->data['tuition_fee'] = $tuition_fee;
                $this->data['wifi'] = $wifi;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;
                $this->data['smoking'] = $smoking;

                $menu_list = [];
                $pdf_menu_list = [];
                $service_tax_list = Setting::getSettingListFromParam('service-tax');

                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;
                $this->data['service_tax_list'] = $service_tax_list;

                break;
            }
            case 78: {
                $working_time = '';
                $object = '';
                $budget = '';
                $smoking = '-1';
                $wifi = '-1';
                $service_tax = 0;
                $parking = '-1';
                $currency = [];

                $this->data['working_time'] = $working_time;
                $this->data['object'] = $object;
                $this->data['budget'] = $budget;
                $this->data['wifi'] = $wifi;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;
                $this->data['smoking'] = $smoking;
                $this->data['currency'] = $currency;

                $menu_list = [];
                $pdf_menu_list = [];
                $service_tax_list = Setting::getSettingListFromParam('service-tax');
                $currency_list = Setting::getSettingListFromParam('currency');

                $this->data['currency_list'] = $currency_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;
                $this->data['service_tax_list'] = $service_tax_list;

                break;
            }
        }

        $this->data['town_id'] = 0;
        $this->data['monday'] = '1';
        $this->data['tuesday'] = '1';
        $this->data['wednessday'] = '1';
        $this->data['thursday'] = '1';
        $this->data['friday'] = '1';
        $this->data['saturday'] = '1';
        $this->data['sunday'] = '1';

        $credit_list = Setting::getSettingListFromParam('credit_card');
        $city_list = Category::getCategoryListFromParam('town-city');
        $tag_list = $category_item->getChildrenCategory;

        $this->loadPageInfoFromChild('poste-town', 'add');

        $this->data['category_item'] = $category_item;
        $this->data['tag_list'] = $tag_list;
        $this->data['credit_list'] = $credit_list;
        $this->data['city_list'] = $city_list;
        // $this->data['regular_list'] = [];

        return view('www.pages.town.update.step2')->with($this->data);
    }

    public function getEdit($article) {
        $article = explode('-', $article);
        $article_id = end($article);

        $article = PosteTown::withTrashed()->with(['getThumbnail', 'getTagList'])->find($article_id);

        if (is_null($article) || ($article->owner_id != Auth::user()->id && Auth::user()->type_id != User::TYPE_ADMIN)) {
            $pageTitle = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
            return view('errors.404')->with($this->data);
        }

        $category_list = Category::getCategoryListFromParam('poste-town');
        $category_id_list = $category_list->pluck('id')->toArray();

        $category_item = $category_list->where('id', $article->category_id)->first();

        if(!in_array($article->category_id, $category_id_list)) {
            $this->data['pageTitle'] = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            return view('errors.404')->with($this->data);
        }

        // Set to check and set data for body tag
        $this->data['scrollspy'] = 1;

        $category_id = $article->category_id;

        $name = $article->name;
        // $tags = '';
        $address = $article->address;
        $city_id = $article->city_id;
        $description = $article->description;
        $route_guide = '';
        $email = '';
        $website = '';
        $facebook = '';
        $credit = [];
        $phone = '';
        $avatar = Base::getUploadURL($article->getThumbnail->name, $article->getThumbnail->dir);
        $map = '';
        $article_tags = [];
        // $regular_close = '';

        if(!is_null($article->route_guide)) {
            $route_guide = $article->route_guide;
        }
        // if(!is_null($article->regular_close)) {
        //     $regular_close = $article->regular_close;
        // }
        if(!is_null($article->email)) {
            $email = $article->email;
        }
        if(!is_null($article->website)) {
            $website = $article->website;
        }
        if(!is_null($article->facebook)) {
            $facebook = $article->facebook;
        }
        if(!is_null($article->credit)) {
            $credit = explode(',', $article->credit);
        }
        if(!is_null($article->phone)) {
            $phone = $article->phone;
        }
        if(!is_null($article->map)) {
            $map = $article->map;
        }
        if(!$article->getTagList->isEmpty()) {
            $article_tags = $article->getTagList->pluck('id')->toArray();
        }

        $this->data['avatar'] = $avatar;
        $this->data['name'] = $name;
        // $this->data['tags'] = $tags;
        $this->data['address'] = $address;
        $this->data['city_id'] = $city_id;
        $this->data['description'] = $description;
        $this->data['route_guide'] = $route_guide;
        $this->data['email'] = $email;
        $this->data['website'] = $website;
        $this->data['facebook'] = $facebook;
        $this->data['credit'] = $credit;
        $this->data['phone'] = $phone;
        $this->data['map'] = $map;
        $this->data['article_tags'] = $article_tags;

        // $this->data['regular_close'] = $regular_close;
        $this->data['monday'] = $article->monday;
        $this->data['tuesday'] = $article->tuesday;
        $this->data['wednessday'] = $article->wednessday;
        $this->data['thursday'] = $article->thursday;
        $this->data['friday'] = $article->friday;
        $this->data['saturday'] = $article->saturday;
        $this->data['sunday'] = $article->sunday;


        $space_images = TownGallery::where('album_id', 1)->where('town_id', $article->id)->orderBy('id', 'DESC')->get();
        $food_images = TownGallery::where('album_id', 2)->where('town_id', $article->id)->orderBy('id', 'DESC')->get();
        $menu_images = TownGallery::where('album_id', 3)->where('town_id', $article->id)->orderBy('id', 'DESC')->get();
        $general_images = TownGallery::where('album_id', 4)->where('town_id', $article->id)->orderBy('id', 'DESC')->get();
        $this->data['space_images'] = $space_images;
        $this->data['food_images'] = $food_images;
        $this->data['menu_images'] = $menu_images;
        $this->data['general_images'] = $general_images;

        switch($category_id) {
            case 68: {
                $working_time = '';
                $budget = '';
                $currency = [];

                if(!is_null($article->working_time)) {
                    $working_time = $article->working_time;
                }
                if(!is_null($article->budget)) {
                    $budget = $article->budget;
                }
                if(!is_null($article->currency)) {
                    $currency = explode(',', $article->currency);
                }
                if(!is_null($article->private_room)) {
                    $private_room = explode(',', $article->private_room);
                } else {
                    $private_room = ['0'];
                }
                if(!is_null($smoking = $article->smoking)) {
                    $smoking = $article->smoking;
                } else {
                    $smoking = '0';
                }
                $usage_scenes = explode(',', $article->usage_scenes);
                if(!is_null($article->wifi)) {
                    $wifi = $article->wifi;
                } else {
                    $wifi = '0';
                }
                $service_tax = $article->service_tax;
                if(!is_null($article->parking)) {
                    $parking = $article->parking;
                } else {
                    $parking = '0';
                }

                $this->data['working_time'] = $working_time;
                $this->data['budget'] = $budget;
                $this->data['private_room'] = $private_room;
                $this->data['smoking'] = $smoking;
                $this->data['currency'] = $currency;
                $this->data['wifi'] = $wifi;
                $this->data['usage_scenes'] = $usage_scenes;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;

                $currency_list = Setting::getSettingListFromParam('currency');
                $service_tax_list = Setting::getSettingListFromParam('service-tax');
                $usage_scene_list = Setting::getSettingListFromParam('restaurant-usage-scenes');
                $private_room_list = Setting::getSettingListFromParam('private-room');
                $menu_list = TownMenu::with('getDetail')->where('town_id', $article->id)->get();
                $pdf_menu_list = TownPDFMenu::where('town_id', $article->id)->get();

                $this->data['currency_list'] = $currency_list;
                $this->data['service_tax_list'] = $service_tax_list;
                $this->data['usage_scene_list'] = $usage_scene_list;
                $this->data['private_room_list'] = $private_room_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 69: {
                $working_time = '';
                $currency = [];


                if(!is_null($article->working_time)) {
                    $working_time = $article->working_time;
                }
                if(!is_null($article->currency)) {
                    $currency = $currency = explode(',', $article->currency);
                }

                if(!is_null($smoking = $article->smoking)) {
                    $smoking = $article->smoking;
                } else {
                    $smoking = '0';
                }
                if(!is_null($article->wifi)) {
                    $wifi = $article->wifi;
                } else {
                    $wifi = '0';
                }
                $service_tax = $article->service_tax;
                if(is_null($article->parking)) {
                    $parking = $article->parking;
                } else {
                    $parking = '0';
                }


                $this->data['working_time'] = $working_time;
                $this->data['currency'] = $currency;
                $this->data['smoking'] = $smoking;
                $this->data['wifi'] = $wifi;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;

                $currency_list = Setting::getSettingListFromParam('currency');
                $menu_list = TownMenu::with('getDetail')->where('town_id', $article->id)->get();
                $pdf_menu_list = TownPDFMenu::where('town_id', $article->id)->get();
                $service_tax_list = Setting::getSettingListFromParam('service-tax');

                $this->data['service_tax_list'] = $service_tax_list;
                $this->data['currency_list'] = $currency_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 70: {
                $budget = '';
                $currency = [];

                if(!is_null($article->budget)) {
                    $budget = $article->budget;
                }
                $check_in = $article->check_in;
                $check_out = $article->check_out;
                $laundry = $article->laundry;
                $breakfast = $article->breakfast;
                $shuttle = $article->shuttle;
                $air_condition = $article->air_condition;
                if(!is_null($article->wifi)) {
                    $wifi = $article->wifi;
                } else {
                    $wifi = '0';
                }
                if(is_null($article->parking)) {
                    $parking = $article->parking;
                } else {
                    $parking = '0';
                }
                $kitchen = $article->kitchen;
                $tv = $article->tv;
                $shower = $article->shower;
                $bathtub = $article->bathtub;
                $luggage = $article->luggage;
                if(!is_null($article->currency)) {
                    $currency = explode(',', $article->currency);
                }

                $this->data['budget'] = $budget;
                $this->data['check_in'] = $check_in;
                $this->data['check_out'] = $check_out;
                $this->data['laundry'] = $laundry;
                $this->data['breakfast'] = $breakfast;
                $this->data['shuttle'] = $shuttle;
                $this->data['air_condition'] = $air_condition;
                $this->data['wifi'] = $wifi;
                $this->data['parking'] = $parking;
                $this->data['kitchen'] = $kitchen;
                $this->data['tv'] = $tv;
                $this->data['shower'] = $shower;
                $this->data['bathtub'] = $bathtub;
                $this->data['luggage'] = $luggage;
                $this->data['currency'] = $currency;

                $currency_list = Setting::getSettingListFromParam('currency');
                $menu_list = TownMenu::with('getDetail')->where('town_id', $article->id)->get();
                $pdf_menu_list = TownPDFMenu::where('town_id', $article->id)->get();

                $this->data['currency_list'] = $currency_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 71: {
                $working_time = '';
                $budget = '';
                $currency = [];

                $working_time = $article->working_time;

                if(!is_null($article->budget)) {
                    $budget = $article->budget;
                }
                if(!is_null($article->currency)) {
                    $currency = explode(',', $article->currency);
                }
                if(!is_null($smoking = $article->smoking)) {
                    $smoking = $article->smoking;
                } else {
                    $smoking = '0';
                }

                if(!is_null($article->wifi)) {
                    $wifi = $article->wifi;
                } else {
                    $wifi = '0';
                }

                $service_tax = $article->service_tax;

                if(is_null($article->parking)) {
                    $parking = $article->parking;
                } else {
                    $parking = '0';
                }


                $this->data['working_time'] = $working_time;
                $this->data['budget'] = $budget;
                $this->data['currency'] = $currency;
                $this->data['smoking'] = $smoking;
                $this->data['wifi'] = $wifi;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;

                $currency_list = Setting::getSettingListFromParam('currency');
                $menu_list = TownMenu::with('getDetail')->where('town_id', $article->id)->get();
                $pdf_menu_list = TownPDFMenu::where('town_id', $article->id)->get();
                $service_tax_list = Setting::getSettingListFromParam('service-tax');

                $this->data['currency_list'] = $currency_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;
                $this->data['service_tax_list'] = $service_tax_list;

                break;
            }
            case 72: {
                $working_time = '';
                $budget = '';
                $currency = [];

                if(!is_null($article->working_time)) {
                    $working_time = $article->working_time;
                }
                if(!is_null($article->budget)) {
                    $budget = $article->budget;
                }
                if(!is_null($article->currency)) {
                    $currency = explode(',', $article->currency);
                }
                if(!is_null($article->wifi)) {
                    $wifi = $article->wifi;
                } else {
                    $wifi = '0';
                }
                if(is_null($article->parking)) {
                    $parking = $article->parking;
                } else {
                    $parking = '0';
                }

                $this->data['working_time'] = $working_time;
                $this->data['budget'] = $budget;
                $this->data['currency'] = $currency;
                $this->data['wifi'] = $wifi;
                $this->data['parking'] = $parking;

                $currency_list = Setting::getSettingListFromParam('currency');
                $menu_list = TownMenu::with('getDetail')->where('town_id', $article->id)->get();
                $pdf_menu_list = TownPDFMenu::where('town_id', $article->id)->get();

                $this->data['currency_list'] = $currency_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 73: {
                $working_time = '';
                $budget = '';
                $currency = [];

                if(!is_null($article->working_time)) {
                    $working_time = $article->working_time;
                }
                if(!is_null($article->budget)) {
                    $budget = $article->budget;
                }
                if(!is_null($article->currency)) {
                    $currency = explode(',', $article->currency);
                }

                $this->data['working_time'] = $working_time;
                $this->data['budget'] = $budget;
                $this->data['currency'] = $currency;

                $currency_list = Setting::getSettingListFromParam('currency');
                $menu_list = TownMenu::with('getDetail')->where('town_id', $article->id)->get();
                $pdf_menu_list = TownPDFMenu::where('town_id', $article->id)->get();

                $this->data['currency_list'] = $currency_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 74: {
                $working_time = '';
                $insurance = 0;
                $language = [];
                $fee_rate = '';
                $department = '';

                if(!is_null($article->working_time)) {
                    $working_time = $article->working_time;
                }
                $insurance = $article->insurance;

                if(!is_null($article->language)) {
                    $language = explode(',', $article->language);
                }
                if(!is_null($article->department)) {
                    $department = $article->department;
                }
                if(!is_null($article->wifi)) {
                    $wifi = $article->wifi;
                } else {
                    $wifi = '0';
                }
                if(is_null($article->parking)) {
                    $parking = $article->parking;
                } else {
                    $parking = '0';
                }
                $service_tax = $article->service_tax;

                $this->data['working_time'] = $working_time;
                $this->data['insurance'] = $insurance;
                $this->data['language'] = $language;
                $this->data['department'] = $department;
                $this->data['wifi'] = $wifi;
                $this->data['parking'] = $parking;
                $this->data['service_tax'] = $service_tax;

                $language_list = Setting::getSettingListFromParam('language');
                $service_tax_list = Setting::getSettingListFromParam('service-tax');

                $this->data['language_list'] = $language_list;
                $this->data['service_tax_list'] = $service_tax_list;

                break;
            }
            case 75: {
                $working_time = '';
                $currency = [];

                if(!is_null($article->working_time)) {
                    $working_time = $article->working_time;
                }
                if(!is_null($article->currency)) {
                    $currency = explode(',', $article->currency);
                }

                if(!is_null($smoking = $article->smoking)) {
                    $smoking = $article->smoking;
                } else {
                    $smoking = '0';
                }
                if(!is_null($article->wifi)) {
                    $wifi = $article->wifi;
                } else {
                    $wifi = '0';
                }
                $service_tax = $article->service_tax;
                if(is_null($article->parking)) {
                    $parking = $article->parking;
                } else {
                    $parking = '0';
                }

                $this->data['working_time'] = $working_time;
                $this->data['currency'] = $currency;
                $this->data['smoking'] = $smoking;
                $this->data['wifi'] = $wifi;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;

                $currency_list = Setting::getSettingListFromParam('currency');
                $menu_list = TownMenu::with('getDetail')->where('town_id', $article->id)->get();
                $pdf_menu_list = TownPDFMenu::where('town_id', $article->id)->get();
                $service_tax_list = Setting::getSettingListFromParam('service-tax');

                $this->data['service_tax_list'] = $service_tax_list;
                $this->data['currency_list'] = $currency_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 76: {
                $working_time = '';
                $currency = [];
                $target_student = '';

                if(!is_null($smoking = $article->smoking)) {
                    $smoking = $article->smoking;
                } else {
                    $smoking = '0';
                }
                if(!is_null($article->wifi)) {
                    $wifi = $article->wifi;
                } else {
                    $wifi = '0';
                }
                $service_tax = $article->service_tax;
                if(is_null($article->parking)) {
                    $parking = $article->parking;
                } else {
                    $parking = '0';
                }

                if(!is_null($article->working_time)) {
                    $working_time = $article->working_time;
                }
                if(!is_null($article->currency)) {
                    $currency = explode(',', $article->currency);
                }
                if(!is_null($article->target_student)) {
                    $target_student = $article->target_student;
                }

                $this->data['working_time'] = $working_time;
                $this->data['currency'] = $currency;
                $this->data['target_student'] = $target_student;
                $this->data['smoking'] = $smoking;
                $this->data['wifi'] = $wifi;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;

                $currency_list = Setting::getSettingListFromParam('currency');
                $menu_list = TownMenu::with('getDetail')->where('town_id', $article->id)->get();
                $pdf_menu_list = TownPDFMenu::where('town_id', $article->id)->get();
                $service_tax_list = Setting::getSettingListFromParam('service-tax');

                $this->data['service_tax_list'] = $service_tax_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;
                $this->data['currency_list'] = $currency_list;

                break;
            }
            case 77: {
                $working_time = '';
                $object = '';
                $tuition_fee = '';
                if(!is_null($smoking = $article->smoking)) {
                    $smoking = $article->smoking;
                } else {
                    $smoking = '0';
                }
                if(!is_null($article->wifi)) {
                    $wifi = $article->wifi;
                } else {
                    $wifi = '0';
                }
                $service_tax = $article->service_tax;
                if(is_null($article->parking)) {
                    $parking = $article->parking;
                } else {
                    $parking = '0';
                }

                if(!is_null($article->working_time)) {
                    $working_time = $article->working_time;
                }
                if(!is_null($article->object)) {
                    $object = $article->object;
                }
                if(!is_null($article->tuition_fee)) {
                    $tuition_fee = $article->tuition_fee;
                }

                $this->data['working_time'] = $working_time;
                $this->data['object'] = $object;
                $this->data['tuition_fee'] = $tuition_fee;
                $this->data['smoking'] = $smoking;
                $this->data['wifi'] = $wifi;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;

                $menu_list = TownMenu::with('getDetail')->where('town_id', $article->id)->get();
                $pdf_menu_list = TownPDFMenu::where('town_id', $article->id)->get();
                $service_tax_list = Setting::getSettingListFromParam('service-tax');

                $this->loadPageInfoFromChild('poste-town', 'edit');

                $this->data['service_tax_list'] = $service_tax_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;

                break;
            }
            case 78: {
                $working_time = '';
                $object = '';
                $budget = '';
                if(!is_null($smoking = $article->smoking)) {
                    $smoking = $article->smoking;
                } else {
                    $smoking = '0';
                }
                if(!is_null($article->wifi)) {
                    $wifi = $article->wifi;
                } else {
                    $wifi = '0';
                }
                $service_tax = $article->service_tax;
                if(is_null($article->parking)) {
                    $parking = $article->parking;
                } else {
                    $parking = '0';
                }
                $currency = [];

                if(!is_null($article->working_time)) {
                    $working_time = $article->working_time;
                }
                if(!is_null($article->object)) {
                    $object = $article->object;
                }
                if(!is_null($article->budget)) {
                    $budget = $article->budget;
                }
                if(!is_null($article->currency)) {
                    $currency = explode(',', $article->currency);
                }

                $this->data['working_time'] = $working_time;
                $this->data['object'] = $object;
                $this->data['budget'] = $budget;
                $this->data['smoking'] = $smoking;
                $this->data['wifi'] = $wifi;
                $this->data['service_tax'] = $service_tax;
                $this->data['parking'] = $parking;
                $this->data['currency'] = $currency;

                $menu_list = TownMenu::with('getDetail')->where('town_id', $article->id)->get();
                $pdf_menu_list = TownPDFMenu::where('town_id', $article->id)->get();
                $service_tax_list = Setting::getSettingListFromParam('service-tax');
                $currency_list = Setting::getSettingListFromParam('currency');

                $this->data['currency_list'] = $currency_list;
                $this->data['menu_list'] = $menu_list;
                $this->data['pdf_menu_list'] = $pdf_menu_list;
                $this->data['service_tax_list'] = $service_tax_list;

                break;
            }
        }

        $this->data['town_id'] = $article->id;

        $credit_list = Setting::getSettingListFromParam('credit_card');
        $city_list = Category::getCategoryListFromParam('town-city');
        // $regular_list = TownRegClose::where('town_id', $article_id)->orderBy('start_date', 'DESC')->orderBy('end_date', 'DESC')->get();\
        $tag_list = $category_item->getChildrenCategory;

        $this->data['category_item'] = $category_item;
        $this->data['credit_list'] = $credit_list;
        $this->data['city_list'] = $city_list;
        $this->data['avatar'] = $avatar;
        $this->data['tag_list'] = $tag_list;
        // $this->data['regular_list'] = $regular_list;


        return view('www.pages.town.update.step2')->with($this->data);
    }

    public function postUpdateFeaturesInfo(Request $request) {
        switch($request->category_id) {
            case 68: {

                if($request->sl_private_room == 1) {
                    if(!empty($request->sl_private_room_content)) {
                        $private_room = implode(',', $request->sl_private_room_content);
                    } else {
                        $private_room = "1";
                    }
                } elseif($request->sl_private_room == -1) {
                    $private_room = '-1';
                } else {
                    $private_room = '0';
                }

                if($request->sl_wifi == 1) {
                    if(!empty($request->ip_wifi)) {
                        $wifi = $request->ip_wifi;
                    } else {
                        $wifi = '1';
                    }
                } elseif($request->sl_wifi == -1) {
                    $wifi = '-1';
                } else {
                    $wifi = '0';
                }

                if($request->sl_smoking == 1) {
                    if(!empty($request->ip_smoking)) {
                        $smoking = $request->ip_smoking;
                    } else {
                        $smoking = '1';
                    }
                } elseif($request->sl_smoking == -1) {
                    $smoking = '-1';
                } else {
                    $smoking = '0';
                }

                if($request->sl_service_tax) {
                    $service_tax = $request->sl_service_tax;
                } else {
                    $service_tax = 0;
                }
                if(!is_null($request->sl_usage_scenes)) {
                    $usage_scenes = implode(',', $request->sl_usage_scenes);
                } else {
                    $usage_scenes = null;
                }

                if($request->sl_parking == 1) {
                    if(!empty($request->ip_parking)) {
                        $parking = $request->ip_parking;
                    } else {
                        $parking = '1';
                    }
                } elseif($request->sl_parking == -1) {
                    $parking = '-1';
                } else {
                    $parking = '0';
                }

                $features = array(
                    'private_room'  => $private_room,
                    'smoking'       => $smoking,
                    'wifi'          => $wifi,
                    'usage_scenes'  => $usage_scenes,
                    'service_tax'   => $service_tax,
                    'parking'       => $parking
                );

                break;
            }

            case 69: {
                if($request->sl_wifi == 1) {
                    if(!empty($request->ip_wifi)) {
                        $wifi = $request->ip_wifi;
                    } else {
                        $wifi = '1';
                    }
                } elseif($request->sl_wifi == -1) {
                    $wifi = '-1';
                } else {
                    $wifi = '0';
                }

                if($request->sl_smoking == 1) {
                    if(!empty($request->ip_smoking)) {
                        $smoking = $request->ip_smoking;
                    } else {
                        $smoking = '1';
                    }
                } elseif($request->sl_smoking == -1) {
                    $smoking = '-1';
                } else {
                    $smoking = '0';
                }

                if($request->sl_service_tax) {
                    $service_tax = $request->sl_service_tax;
                } else {
                    $service_tax = 0;
                }

                if($request->sl_parking == 1) {
                    if(!empty($request->ip_parking)) {
                        $parking = $request->ip_parking;
                    } else {
                        $parking = '1';
                    }
                } elseif($request->sl_parking == -1) {
                    $parking = '-1';
                } else {
                    $parking = '0';
                }

                $features = array(
                    'smoking'       => $smoking,
                    'wifi'          => $wifi,
                    'service_tax'   => $service_tax,
                    'parking'       => $parking
                );

                break;
            }

            case 70: {
                if($request->sl_laundry) {
                    if(!empty($request->ip_laundry)) {
                        $laundry = $request->ip_laundry;
                    } else {
                        $laundry = '1';
                    }
                } elseif($request->sl_laundry == -1) {
                    $laundry = '-1';
                } else {
                    $laundry = '0';
                }

                if($request->sl_breakfast) {
                    if(!empty($request->ip_breakfast)) {
                        $breakfast = $request->ip_breakfast;
                    } else {
                        $breakfast = '1';
                    }
                } elseif($request->sl_breakfast == -1) {
                    $breakfast = '-1';
                } else {
                    $breakfast = '0';
                }
                if($request->sl_wifi == 1) {
                    if(!empty($request->ip_wifi)) {
                        $wifi = $request->ip_wifi;
                    } else {
                        $wifi = '1';
                    }
                } elseif($request->sl_wifi == -1) {
                    $wifi = '-1';
                } else {
                    $wifi = '0';
                }
                if($request->sl_parking == 1) {
                    if(!empty($request->ip_parking)) {
                        $parking = $request->ip_parking;
                    } else {
                        $parking = '1';
                    }
                } elseif($request->sl_parking == -1) {
                    $parking = '-1';
                } else {
                    $parking = '0';
                }

                $features = array(
                    'check_in'      => $request->check_in,
                    'check_out'     => $request->check_out,
                    'laundry'       => $laundry,
                    'breakfast'     => $breakfast,
                    'shuttle'       => $request->sl_shuttle,
                    'air_condition' => $request->sl_air_condition,
                    'wifi'          => $wifi,
                    'parking'       => $parking,
                    'kitchen'       => $request->sl_kitchen,
                    'tv'            => $request->sl_tv,
                    'shower'        => $request->sl_shower,
                    'bathtub'       => $request->sl_bathtub,
                    'luggage'       => $request->sl_luggage
                );

                break;
            }
            case 71: {
                if($request->sl_wifi == 1) {
                    if(!empty($request->ip_wifi)) {
                        $wifi = $request->ip_wifi;
                    } else {
                        $wifi = '1';
                    }
                } elseif($request->sl_wifi == -1) {
                    $wifi = '-1';
                } else {
                    $wifi = '0';
                }

                if($request->sl_smoking == 1) {
                    if(!empty($request->ip_smoking)) {
                        $smoking = $request->ip_smoking;
                    } else {
                        $smoking = '1';
                    }
                } elseif($request->sl_smoking == -1) {
                    $smoking = '-1';
                } else {
                    $smoking = '0';
                }

                if($request->sl_service_tax) {
                    $service_tax = $request->sl_service_tax;
                } else {
                    $service_tax = 0;
                }

                if($request->sl_parking == 1) {
                    if(!empty($request->ip_parking)) {
                        $parking = $request->ip_parking;
                    } else {
                        $parking = '1';
                    }
                } elseif($request->sl_parking == -1) {
                    $parking = '-1';
                } else {
                    $parking = '0';
                }

                $features = array(
                    'smoking'       => $smoking,
                    'wifi'          => $wifi,
                    'service_tax'   => $service_tax,
                    'parking'       => $parking
                );

                break;
            }
            case 72: {
                if($request->sl_wifi == 1) {
                    if(!empty($request->ip_wifi)) {
                        $wifi = $request->ip_wifi;
                    } else {
                        $wifi = '1';
                    }
                } elseif($request->sl_wifi == -1) {
                    $wifi = '-1';
                } else {
                    $wifi = '0';
                }

                if($request->sl_parking == 1) {
                    if(!empty($request->ip_parking)) {
                        $parking = $request->ip_parking;
                    } else {
                        $parking = '1';
                    }
                } elseif($request->sl_parking == -1) {
                    $parking = '-1';
                } else {
                    $parking = '0';
                }

                $features = array(
                    'wifi'          => $wifi,
                    'parking'       => $parking
                );

                break;
            }
            case 74: {
                $insurance          = $request->sl_insurance;
                $department         = $request->department;
                if($request->sl_wifi == 1) {
                    if(!empty($request->ip_wifi)) {
                        $wifi = $request->ip_wifi;
                    } else {
                        $wifi = '1';
                    }
                } elseif($request->sl_wifi == -1) {
                    $wifi = '-1';
                } else {
                    $wifi = '0';
                }

                if($request->sl_smoking == 1) {
                    if(!empty($request->ip_smoking)) {
                        $smoking = $request->ip_smoking;
                    } else {
                        $smoking = '1';
                    }
                } elseif($request->sl_smoking == -1) {
                    $smoking = '-1';
                } else {
                    $smoking = '0';
                }

                if($request->sl_service_tax) {
                    $service_tax = $request->sl_service_tax;
                } else {
                    $service_tax = 0;
                }

                if($request->sl_parking == 1) {
                    if(!empty($request->ip_parking)) {
                        $parking = $request->ip_parking;
                    } else {
                        $parking = '1';
                    }
                } elseif($request->sl_parking == -1) {
                    $parking = '-1';
                } else {
                    $parking = '0';
                }

                if(!empty($request->language)) {
                    $language           = implode(',', $request->language);
                } else {
                    $language = null;
                }
                $features = array(
                    'insurance'             => $insurance,
                    'department'            => $department,
                    'language'              => $language,
                    'smoking'       => $smoking,
                    'wifi'          => $wifi,
                    'service_tax'   => $service_tax,
                    'parking'       => $parking
                );
                break;
            }
            case 75: {
                if($request->sl_wifi == 1) {
                    if(!empty($request->ip_wifi)) {
                        $wifi = $request->ip_wifi;
                    } else {
                        $wifi = '1';
                    }
                } elseif($request->sl_wifi == -1) {
                    $wifi = '-1';
                } else {
                    $wifi = '0';
                }

                if($request->sl_smoking == 1) {
                    if(!empty($request->ip_smoking)) {
                        $smoking = $request->ip_smoking;
                    } else {
                        $smoking = '1';
                    }
                } elseif($request->sl_smoking == -1) {
                    $smoking = '-1';
                } else {
                    $smoking = '0';
                }

                if($request->sl_service_tax) {
                    $service_tax = $request->sl_service_tax;
                } else {
                    $service_tax = 0;
                }

                if($request->sl_parking == 1) {
                    if(!empty($request->ip_parking)) {
                        $parking = $request->ip_parking;
                    } else {
                        $parking = '1';
                    }
                } elseif($request->sl_parking == -1) {
                    $parking = '-1';
                } else {
                    $parking = '0';
                }

                $features = array(
                    'smoking'       => $smoking,
                    'wifi'          => $wifi,
                    'service_tax'   => $service_tax,
                    'parking'       => $parking
                );

                break;
            }
            case 76: {

                if($request->sl_wifi == 1) {
                    if(!empty($request->ip_wifi)) {
                        $wifi = $request->ip_wifi;
                    } else {
                        $wifi = '1';
                    }
                } elseif($request->sl_wifi == -1) {
                    $wifi = '-1';
                } else {
                    $wifi = '0';
                }

                if($request->sl_smoking == 1) {
                    if(!empty($request->ip_smoking)) {
                        $smoking = $request->ip_smoking;
                    } else {
                        $smoking = '1';
                    }
                } elseif($request->sl_smoking == -1) {
                    $smoking = '-1';
                } else {
                    $smoking = '0';
                }

                if($request->sl_service_tax) {
                    $service_tax = $request->sl_service_tax;
                } else {
                    $service_tax = 0;
                }

                if($request->sl_parking == 1) {
                    if(!empty($request->ip_parking)) {
                        $parking = $request->ip_parking;
                    } else {
                        $parking = '1';
                    }
                } elseif($request->sl_parking == -1) {
                    $parking = '-1';
                } else {
                    $parking = '0';
                }

                $target_student = $request->target_student;

                $features = array(
                    'target_student' => $target_student,
                    'smoking'       => $smoking,
                    'wifi'          => $wifi,
                    'service_tax'   => $service_tax,
                    'parking'       => $parking
                );
                break;
            }
            case 77: {
                if($request->sl_wifi == 1) {
                    if(!empty($request->ip_wifi)) {
                        $wifi = $request->ip_wifi;
                    } else {
                        $wifi = '1';
                    }
                } elseif($request->sl_wifi == -1) {
                    $wifi = '-1';
                } else {
                    $wifi = '0';
                }

                if($request->sl_smoking == 1) {
                    if(!empty($request->ip_smoking)) {
                        $smoking = $request->ip_smoking;
                    } else {
                        $smoking = '1';
                    }
                } elseif($request->sl_smoking == -1) {
                    $smoking = '-1';
                } else {
                    $smoking = '0';
                }

                if($request->sl_service_tax) {
                    $service_tax = $request->sl_service_tax;
                } else {
                    $service_tax = 0;
                }

                if($request->sl_parking == 1) {
                    if(!empty($request->ip_parking)) {
                        $parking = $request->ip_parking;
                    } else {
                        $parking = '1';
                    }
                } elseif($request->sl_parking == -1) {
                    $parking = '-1';
                } else {
                    $parking = '0';
                }
                $object         = $request->object;
                $tuition_fee    = $request->tuition_fee;

                $features = array(
                    'smoking'       => $smoking,
                    'wifi'          => $wifi,
                    'service_tax'   => $service_tax,
                    'parking'       => $parking,
                    'object'        => $object,
                    'tuition_fee'   => $tuition_fee
                );

                break;
            }
            case 78: {
                $object = $request->object;
                if($request->sl_wifi == 1) {
                    if(!empty($request->ip_wifi)) {
                        $wifi = $request->ip_wifi;
                    } else {
                        $wifi = '1';
                    }
                } elseif($request->sl_wifi == -1) {
                    $wifi = '-1';
                } else {
                    $wifi = '0';
                }

                if($request->sl_smoking == 1) {
                    if(!empty($request->ip_smoking)) {
                        $smoking = $request->ip_smoking;
                    } else {
                        $smoking = '1';
                    }
                } elseif($request->sl_smoking == -1) {
                    $smoking = '-1';
                } else {
                    $smoking = '0';
                }

                if($request->sl_service_tax) {
                    $service_tax = $request->sl_service_tax;
                } else {
                    $service_tax = 0;
                }

                if($request->sl_parking == 1) {
                    if(!empty($request->ip_parking)) {
                        $parking = $request->ip_parking;
                    } else {
                        $parking = '1';
                    }
                } elseif($request->sl_parking == -1) {
                    $parking = '-1';
                } else {
                    $parking = '0';
                }

                $features = array(
                    'object' => $object,
                    'smoking'       => $smoking,
                    'wifi'          => $wifi,
                    'service_tax'   => $service_tax,
                    'parking'       => $parking
                );
                break;
            }

            default: {
                $features = array();
            }
        }

        $result = PosteTown::updateFeatures($request->town_id, $features);
        if($result) {
            return response()->json([
                'result' => 1
            ]);
        }

        return response()->json([
            'result' => 0
        ]);
    }


    public function postUpdateBasicInfo(TownBasicInfoRequest $request) {
        $avatar_id = 0;
        if($request->hasFile('avatar')) {
            $file = $request->avatar;

            if(!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'poste-town', 'avatar');
                $avatar_id = $gallery_id;
            }
        }

        $slug = str_slug($request->name, '-');

        if(!empty($request->credit)) {
            $credit = implode(',', $request->credit);
        } else {
            $credit = null;
        }

        if(!empty($request->currency)) {
            $currency = implode(',', $request->currency);
        } else {
            $currency = null;
        }

        if(!empty($request->working_time)) {
            $working_time = $request->working_time;
        } else {
            $working_time = null;
        }

        // if(!empty($request->regular_close)) {
        //     $regular_close = $request->regular_close;
        // } else {
        //     $regular_close = null;
        // }

        if(!empty($request->budget)) {
            $budget = $request->budget;
        } else {
            $budget = null;
        }

        if(!empty($request->map)) {
            $map = $request->map;
        } else {
            $map = null;
        }

        $data = array(
            'name'          => $request->name,
            'slug'          => $slug,
            'avatar'        => $avatar_id,
            // 'tags'          => $request->tags,
            'description'   => $request->description,
            'city_id'       => $request->city_id,
            'address'       => $request->address,
            'route_guide'   => $request->route_guide,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'website'       => $request->website,
            'facebook'      => $request->facebook,
            'user_id'       => Auth::user()->id,
            'category_id'   => $request->category_id,
            'credit'        => $credit,
            'currency'      => $currency,
            'working_time'  => $working_time,
            'budget'        => $budget,
            'map'           => $map,
            'owner_id'      => Auth::user()->id
            // 'regular_close' => $regular_close
        );

        if($request->town_id == 0) {
            $data['end_free_date'] = date('Y-m-d', strtotime('+30 days'));
        }

        $result = PosteTown::updateBasicInfo($request->town_id, $data);

        if($result) {

            $pdf_id_str = $request->pdf_ids;
            $pdf_ids = explode(',', $pdf_id_str);

            foreach($pdf_ids as $pdf_id) {
                $pdf_item = TownPDFMenu::find($pdf_id);

                if(!is_null($pdf_item)) {
                    $pdf_item->town_id = $result->id;
                    $pdf_item->save();
                }
            }

            $article_tags = TownTag::where('town_id', $result->id)->get();
            $request_tag_list = $request->tags ?? [];
            foreach ($article_tags as $tag) {
                $key = array_search($tag->id, $request_tag_list);

                if($key !== false) {
                    unset($request_tag_list[$key]);
                } else {
                    $tag->delete();
                }
            }
            $tag_result_check = true;
            foreach ($request_tag_list as $tag_id) {
                $tag_result = false;
                $tag_result = TownTag::create([
                    'town_id' => $result->id,
                    'tag_id' => $tag_id
                ]);

                if(!$tag_result) {
                    $tag_result_check = false;
                    break;
                }
            }

            if($tag_result_check) {
                return response()->json([
                    'result' => 1,
                    'town_id' => $result->id
                ]);
            }
        }
        return response()->json([
            'result' => 0
        ]);
    }

    public function postImageGallery(TownGalleryRequest $request) {
        if($request->hasFile('image')) {
            $file = $request->image;
            $town_id = $request->town_id;
            $type = $request->type;
            $file_url = [];
            $gallery_ids = [];

            if(!is_null($file)) {
                $imgf = new ImageFactory();
                $file_url_arr = $imgf->upload(array($file), 'poste-town');

                foreach($file_url_arr as $url) {
                    $gallery_id = TownGallery::updateItem($url, $town_id, $type);

                    $file_url[] = $url;
                    $gallery_ids[] = $gallery_id;
                }

            }
            return response()->json([
                'result' => 1,
                'file_urls' => $file_url,
                'gallery_ids' => $gallery_ids
            ]);
        }

        return response()->json([
            'result' => 0
        ]);
    }

    public function postSaveGallery(Request $request) {
        $town_id = $request->town_id;
        $menu_ids = [];
        $food_ids = [];
        $space_ids = [];
        $general_ids = [];

        if(!is_null($request->menu_ids)) {
            $menu_ids = explode(',', $request->menu_ids);
        }
        if(!is_null($request->food_ids)) {
            $food_ids = explode(',', $request->food_ids);
        }
        if(!is_null($request->space_ids)) {
            $space_ids = explode(',', $request->space_ids);
        }
        if(!is_null($request->general_ids)) {
            $general_ids = explode(',', $request->general_ids);
        }

        foreach($menu_ids as $id) {
            $result = TownGallery::saveTownID($id, $town_id);
            if(!$result) {
                return response()->json([
                    'result' => 0
                ]);
            }
        }
        foreach($food_ids as $id) {
            $result = TownGallery::saveTownID($id, $town_id);
            if(!$result) {
                return response()->json([
                    'result' => 0
                ]);
            }
        }
        foreach($space_ids as $id) {
            $result = TownGallery::saveTownID($id, $town_id);
            if(!$result) {
                return response()->json([
                    'result' => 0
                ]);
            }
        }
        foreach($general_ids as $id) {
            $result = TownGallery::saveTownID($id, $town_id);
            if(!$result) {
                return response()->json([
                    'result' => 0
                ]);
            }
        }
        return response()->json([
            'result' => 1
        ]);
    }

    public function postUpdateMenu(MenuFormRequest $request) {
        $town_id = $request->town_id;
        $menu_name = $request->food_section;
        $menu_id = $request->menu_section_id;
        $food_ids = $request->food_ids;
        $food_images = $request->food_image;
        $food_names = $request->food_name;
        $food_prices = $request->food_price;
        $check_images = json_decode($request->imgFoods);

        if(!empty($food_names)) {
            $check = false;

            foreach($food_names as $name) {
                if(!empty($name)) {
                    $check = true;
                }
            }

            if($check) {

                $menu = TownMenu::find($menu_id);
                if(is_null($menu)) {
                    $menu = TownMenu::create(array(
                        'name' => $menu_name,
                        'town_id' => $town_id
                    ));
                    $menu_id = $menu->id;
                }

                $menu->name = $menu_name;
                $menu->save();

                for($i = 0; $i < count($food_names); $i++) {
                    if(!empty($food_names[$i])) {

                        $food = TownMenuDetail::find($food_ids[$i]);

                        $food_image_id = 0;
                        if(!empty($food_images[$i])) {
                            $file = $food_images[$i];
                            $imgf = new ImageFactory();
                            $food_image_id_arr = Gallery::uploadImage(array($file), 'pote-town', 'food-image', 'thumb');
                            $food_image_id = $food_image_id_arr[0];
                        }

                        $data = array(
                            'food_image' => $food_image_id,
                            'name' => $food_names[$i],
                            'price' => $food_prices[$i],
                            'menu_id' => $menu->id
                        );

                        if(is_null($food)) {
                            $food = TownMenuDetail::create($data);
                        } else {
                            if($food->food_image != $food_image_id && $food_image_id != 0) {
                                if($food->food_image != 0) {
                                    Gallery::clearGallery($food->food_image, 'town-food', $food->id);
                                }
                                $food->food_image = $food_image_id;
                            }
                            $food->name = $food_names[$i];
                            $food->price = $food_prices[$i];
                            $food->save();
                        }
                    }
                }
            }
        }

        return response()->json([
            'result' => 1
        ]);
    }

    public function postUploadPDFMenu(PDFRequest $request) {
        if($request->hasFile('file')) {
            $file = $request->file;
            $town_id = $request->town_id;
            $dir = 'pdf_menu';
            $url = '';

            if(!is_null($file)) {
                // Generate random dir
                $dir = trim($dir, '/');
                $filename = $dir.'_'.date('Ymd').'-'.microtime(true).'.'.strtolower($file->getClientOriginalExtension());

                // Get file info and try to move
                $destination = public_path().'/upload/'.$dir.'/';
                $path = $dir.'/'.$filename;
                $uploaded = $file->move($destination, $filename);

                if ($uploaded) {
                    $url = asset('upload/'.$path);
                }
            }

            if(!empty($url)) {
                $fileData = Base::getUploadFilename($url);
                $data = array(
                    'name' => $fileData['filename'],
                    'dir' => $fileData['dir'],
                    'town_id' => $town_id
                );

                $file = TownPDFMenu::create($data);

                if(!is_null($file)) {
                    return response()->json([
                        'result' => 1,
                        'url' => $url,
                        'id' => $file->id
                    ]);
                }
            }
        }
    }

    public function postDeleteGallery(Request $request) {
        $result = TownGallery::deleteItem($request->id);

        if($result) {
            return response()->json([
                'result' => 1
            ]);
        }

        return response()->json([
            'result' => 0
        ]);
    }

    public function postDeleteFood(Request $request) {
        $food = TownMenuDetail::find($request->id);

        if(!is_null($food)) {
            if($food->food_image != 0) {
                Gallery::clearGallery($food->food_image, 'town-food', $food->id);
            }
            $food->delete();
            return response()->json([
                'result' => 1
            ]);
        }

        return response()->json([
            'result' => 0
        ]);
    }

    public function postDeleteMenu(Request $request) {
        $menu = TownMenu::with('getDetail')->find($request->id);

        if(!is_null($menu)) {
            foreach($menu->getDetail as $food) {
                if ($food->food_image != 0) {
                    Gallery::clearGallery($food->food_image, 'town-food', $food->id);
                }

                $food->delete();
            }

            $menu->delete();

            return response()->json([
                'result' => 1
            ]);
        }

        return response()->json([
            'result' => 0
        ]);
    }

    public function postDeletePDF(Request $request) {
        $result = TownPDFMenu::deletePDF($request->id);

        return response()->json([
            'result' => $result
        ]);
    }

    public function postUpdateWorkingTime(Request $request) {

        $status_arr = $request->status_working_time;
        $open_arr = $request->working_time_open;
        $open1_arr = $request->working_time_open1;
        $close_arr = $request->working_time_close;
        $close1_arr = $request->working_time_close1;
        $note_arr = $request->working_time_note;

        $data = array();
        $index_time = 0;

        foreach($status_arr as $key => $status) {

            if($status) {
                $element = '1';

                if(!empty($open1_arr[$index_time]) && !empty($close1_arr[$index_time])) {
                    if($open_arr[$index_time] > $open1_arr[$index_time]) {
                        $temp = $open1_arr[$index_time];
                        $open1_arr[$index_time] = $open_arr[$index_time];
                        $open_arr[$index_time] = $temp;


                        $temp = $close1_arr[$index_time];
                        $close1_arr[$index_time] = $close_arr[$index_time];
                        $close_arr[$index_time] = $temp;
                    }

                    $open_time = $open_arr[$index_time].','.$open1_arr[$index_time];
                    $close_time = $close_arr[$index_time].','.$close1_arr[$index_time];
                } else {
                    $open_time = $open_arr[$index_time];
                    $close_time = $close_arr[$index_time];
                }

                $element .= '-'.$open_time.'-'.$close_time;

                $index_time++;
            } else {
                $element = '0-0-0';
            }

            if(!empty($note_arr[$key])) {
                $element .= '-'.$note_arr[$key];
            }

            switch($key) {
                case 0:
                $data['monday'] = $element;
                break;
                case 1:
                $data['tuesday'] = $element;
                break;
                case 2:
                $data['wednessday'] = $element;
                break;
                case 3:
                $data['thursday'] = $element;
                break;
                case 4:
                $data['friday'] = $element;
                break;
                case 5:
                $data['saturday'] = $element;
                break;
                case 6:
                $data['sunday'] = $element;
                break;
            }
        }

        $result = PosteTown::updateWorkingTime($request->town_id, $data);

        if($result) {
            return response()->json([
                'result' => 1
            ]);
        }

        return response()->json([
            'result' => 0
        ]);
    }

    public function postUpdateRegularClose(Request $request) {
        $town_id = $request->town_id;
        $start_arr = $request->start_date;
        $end_arr = $request->end_date;
        $note_arr = $request->note;
        $id_arr = $request->id;

        $result = true;
        if(!is_null($start_arr)) {
            for($i = 0; $i < count($start_arr); $i++) {
                if(!empty($start_arr[$i]) && !empty($end_arr[$i])) {

                    $start_date = date_create_from_format('m-d-Y', $start_arr[$i]);
                    $end_date = date_create_from_format('m-d-Y', $end_arr[$i]);

                    $data = array(
                        'town_id'       => $town_id,
                        'start_date'    => $start_date->format('Y-m-d'),
                        'end_date'      => $end_date->format('Y-m-d'),
                        'note'          => $note_arr[$i]
                    );

                    $item = TownRegClose::find($id_arr[$i]);

                    if(!is_null($item)) {
                        $result = $item->update($data);
                    } else {
                        $result = TownRegClose::create($data);
                    }

                    if(!$result) {
                        $result = false;
                        break;
                    }
                }
            }
        }

        if($result) {
            return response()->json([
                'result' => 1
            ]);
        }
        return response()->json([
            'result' => 0
        ]);
    }

    public function postDeleteRegularTime(Request $request) {
        $id = $request->id;

        $item = TownRegClose::find($id);

        if(!is_null($item)) {
            $item->delete();

            return response()->json([
                'result' => 1
            ]);
        }
    }


}
