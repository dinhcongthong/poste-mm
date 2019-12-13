<?php
namespace App\Http\Controllers;

use HTML;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

use App\Models\AdPosition;
use App\Models\Base;
use App\Models\Category;
use App\Models\Meta;
use App\Models\News;
use App\Models\Param;
use App\Models\PosteNotification;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $breadcrumb = '';
    protected $scripts = '';
    protected $stylesheets = '';
    protected $pageTitle = '';
    protected $pageDescription = '';
    protected $pageImage = '';
    protected $pageKeywords = '';
    protected $pageType = '';
    protected $segment = '';
    protected $segment2 = '';
    protected $segment3 = '';

    public function __construct() {
        date_default_timezone_set('Asia/Yangon');
        $this->segment = Request()->segment(1);
        $this->segment2 = Request()->segment(2);
        $this->segment3 = Request()->segment(3);

        $this->createResources();

        $this->loadMetaTagContent();

        $this->data['breadcrumb'] = $this->breadcrumb;
        $this->data['pageTitle'] = $this->pageTitle;
        $this->data['pageDescription'] = $this->pageDescription;
        if(empty($this->pageImage)) {
            $this->data['pageImage'] = asset('images/poste/logo.png');
        } else {
            $this->data['pageImage'] = $this->pageImage;
        }
        $this->data['pageKeywords'] = $this->pageKeywords;

        $this->data['stylesheets'] = $this->stylesheets;
        $this->data['scripts'] = $this->scripts;
        $this->data['segment'] = $this->segment;
        $this->data['segment2'] = $this->segment2;
        $this->data['segment3'] = $this->segment3;


        $this->data['businessCategoryList'] = Category::getBusinessCategoryList();
        $this->data['lifetipCategoryList'] = Category::getCategoryListFromParam('lifetip', 'category');
        $this->data['posteTownCategoryList'] = Category::getCategoryListFromParam('poste-town', 'category');
        $this->data['dailyinfoCategoryList'] = Category::getCategoryListFromParam('dailyinfo', 'category');



        // Unread Notification
        $this->middleware(function ($request, $next) {
            if(Auth::check()) {
                $user_id = Auth::user()->id;

                $notify_list = PosteNotification::with(['getPosteTown', 'getBusinesses'])->where('owner_id', $user_id)->orderBy('created_at', 'desc')->get();
            } else {
                $notify_list = collect();
            }
            $this->data['notify_list'] = $notify_list;
            return $next($request);
        });
    }

    public function createResources() {
        if($this->segment == 'admin') {
            /* Admin Resources */
            // Adver
            $ad_home_pc_top_list = AdPosition::getAdListShow(1, 1);
            $this->data['ad_home_pc_top_list'] = $ad_home_pc_top_list;
            $this->data['ad_dailyinfo_mobile_top_banner'] = AdPosition::getAdListShow(8, 1);
            $this->loadAdminResources();
        } elseif($this->segment == 'account-setting') {
            $this->pageTitle = 'Management Page | '.$this->pageTitle;
            $this->breadcrumb = 'Management ';

            switch($this->segment2) {
                case 'town': {
                    $this->pageTitle = 'Poste Town Management | ミャンマー生活情報サイトPOSTE（ポステ）';
                    $this->breadcrumb .= ' > Poste Town';
                    break;
                }
                case 'business': {
                    $this->pageTitle = 'Business Management | ミャンマー生活情報サイトPOSTE（ポステ）';
                    $this->breadcrumb .= ' > Business';
                    break;
                }
            }
        } else {
            $this->loadPageResouces();
        }
    }

    public function loadAdminResources() {
        $this->breadcrumb = 'dasboard';
        if(!empty($this->segment2)) {
            $this->breadcrumb .= ' > '.$this->segment2;
        }
        if(!empty($this->segment3)) {
            $this->breadcrumb .= ' > '.$this->segment3;
        }
        switch($this->segment2) {
            /* Admin Ads Routes */
            case 'ads': {
                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Advertisement';
                        $this->scripts .=
                        HTML::script('_admin/js/ad.js');
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit Advertisement';
                        $this->scripts .=
                        HTML::script('_admin/js/ad.js');
                        break;
                    }
                    case 'position': {
                        /* Ad Ads Position Routes */
                        $this->scripts .= HTML::script('_admin/js/ad-position.js');
                        $segment4 = Request()->segment(4);
                        if(!empty($segment4)) {
                            $this->breadcrumb .= ' > '.$segment4;
                        }
                        switch($segment4) {
                            case 'add': {
                                $this->pageTitle = 'Add Ads Position';
                                break;
                            }
                            case 'edit': {
                                $this->pageTitle = 'Edit Ads Position';
                                break;
                            }
                            default: {
                                $this->pageTitle = 'Ads Position Management';
                            }
                        }
                        break;
                    }
                    default: {
                        $this->scripts .=
                        HTML::script('_admin/js/ad.js');
                        $this->pageTitle = 'Advertisements Management';
                    }
                }
                break;
            }
            // Admin Gallery Routes
            case 'gallery': {
                $this->stylesheets .= HTML::style('_admin/css/gallery.css');
                $this->scripts .= HTML::script('_admin/js/gallery.js');
                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Gallery';
                        break;
                    }
                    default: {
                        $this->pageTitle = 'Galleries Management';
                    }
                }
                break;
            }
            // Admin Dailyinfo Routes
            case 'dailyinfo': {
                $this->scripts .=
                HTML::script('_admin/js/dailyinfo.js');
                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Dailyinfo Article';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit Dailyinfo Article';
                        break;
                    }
                    case 'preview': {
                        $this->pageTitle = 'Preview Dailyinfo Article';
                        $this->stylesheets .=
                        HTML::style('www/css/dailyinfo.css').
                        HTML::style('vendors/ckeditor4/plugins/styles/release.css');
                        $this->scripts .=
                        HTML::script('www/js/main.js').
                        HTML::script('www/js/dailyinfo.js');
                        break;
                    }
                    default: {
                        $this->pageTitle = 'Dailyinfo Management';
                    }
                }
                break;
            }
            // Admin Lifetip Routes
            case 'lifetip': {
                $this->scripts .=
                HTML::script('_admin/js/lifetip.js');
                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Lifetip Article';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit Lifetip Article';
                        break;
                    }
                    case 'preview': {
                        $this->pageTitle = 'Preview Lifetip Article';
                        $this->stylesheets .=
                        HTML::style('www/css/lifetip.css').
                        HTML::style('vendors/ckeditor4/plugins/styles/release.css');
                        $this->scripts .=
                        HTML::script('www/js/main.js').
                        HTML::script('www/js/lifetip.js');
                        break;
                    }
                    default: {
                        $this->pageTitle = 'Lifetip Management';
                    }
                }
                break;
            }
            // Admin Business Routes
            case 'business': {
                $this->pageTitle = 'Business Management';
                $this->scripts .=
                HTML::script('_admin/js/business.js');
                break;
            }
            // Admin Poste Town Route
            case 'poste-town': {
                $this->pageTitle = 'Poste Town Management';
                $this->scripts =
                HTML::script('_admin/js/town.js');
                break;
            }
            // Admin Golf Station Routes
            case 'golf': {
                $this->scripts .=
                HTML::script('_admin/js/golf.js');
                $this->data['type'] = 'golf';
                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Golf';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit Golf';
                        break;
                    }
                    default: {
                        $this->pageTitle = 'Golf Management';
                    }
                }
                break;
            }
            // Admin Golf Shop Routes
            case 'golf-shop': {
                $this->scripts .=
                HTML::script('_admin/js/golf.js');
                $this->data['type'] = 'golf-shop';
                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Golf Shop';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit Golf Shop';
                        break;
                    }
                    default: {
                        $this->pageTitle = 'Golf Shop Management';
                    }
                }
                break;
            }
            // Admin Movie Routes
            case 'movie': {
                $this->scripts .=
                HTML::script('_admin/js/movie.js');
                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Movie';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit Movie';
                        break;
                    }
                    default: {
                        $this->pageTitle = 'Movie Management';
                    }
                }
                break;
            }
            // Admin Theater Routes
            case 'theater': {
                $this->scripts =
                HTML::script('_admin/js/theater.js');
                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Cinema Theater';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit Cinema Theater';
                        break;
                    }
                    default: {
                        $this->pageTitle = 'Cinema Theater Management';
                    }
                }
                break;
            }
            // Admin Showtime
            case 'movie-show-time': {
                $this->scripts =
                HTML::script('_admin/js/showtime.js');
                break;
            }
            // Admin Personal-Trading Routes
            case 'personal-trading': {
                $this->scripts .= HTML::script('_admin/js/personal-trading.js');
                $this->pageTitle = "Personal Trading Management";
                break;
            }
            // Admin job-searchings Routes
            case 'job-searching': {
                $this->scripts .= HTML::script('_admin/js/job-searching.js');
                $this->pageTitle = "Job Searching Management";
                break;
            }
            // Admin bull-board Routes
            case 'bull-board': {
                $this->scripts .= HTML::script('_admin/js/bull-board.js');
                $this->pageTitle = "Bullboard Management";
                break;
            }
            // Admin real-estate Routes
            case 'real-estate': {
                $this->scripts .= HTML::script('_admin/js/real-estate.js');
                $this->pageTitle = "Realestate Management";
                break;
            }
            // Admin Category Routes
            case 'category': {
                $this->scripts .= HTML::script('_admin/js/category.js');
                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Category';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Modify A Category';
                        break;
                    }
                    default: {
                        $this->pageTitle = 'Categories Management';
                    }
                }
                break;
            }
            // Admin Sub Category Routes
            case 'sub-category': {
                $this->scripts .= HTML::script('_admin/js/sub-category.js');
                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Sub-Category';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Modify A Sub-Category';
                        break;
                    }
                    default:{
                        $this->pageTitle = 'Sub-Categories Management';
                    }
                }
                break;
            }
            // Admin Param Routes
            case 'param': {
                $this->scripts .= HTML::script('_admin/js/param.js');
                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Param';
                        break;
                    }
                    default: {
                        $this->pageTitle = 'Params Management';
                    }
                }
                break;
            }
            // Admin Customer Routes
            case 'customer': {
                $this->scripts .= HTML::script('_admin/js/customer.js');
                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Customer';
                        break;
                    }
                    default: {
                        $this->pageTitle = 'Customers Management';
                    }
                }
                break;
            }
            // Admin City Routes
            case 'city':{
                $this->scripts .= HTML::script('_admin/js/city.js');
                switch($this->segment3) {
                    case 'add':{
                        $this->pageTitle = 'Add New City';
                        break;
                    }
                    default: {
                        $this->pageTitle = 'City Management';
                    }
                }
                break;
            }
            // Admin District Routes
            case 'district':{
                $this->scripts .= HTML::script('_admin/js/district.js');
                switch($this->segment3) {
                    case 'add':{
                        $this->pageTitle = 'Add New District';
                        break;
                    }
                    default: {
                        $this->pageTitle = 'District Management';
                    }
                }
                break;
            }
            // Admin User Routes
            case 'user':{
                $this->scripts .= HTML::script('_admin/js/user.js');
                switch($this->segment3) {
                    default: {
                        $this->pageTitle = 'Users Management';
                    }
                }
                break;
            }
            case 'setting':{
                $this->scripts =
                HTML::script('_admin/js/setting.js');
                switch($this->segment3) {
                    case 'add':{
                        $this->pageTitle = 'Add New Setting';
                        break;
                    }
                    case 'edit':{
                        $this->pageTitle = 'Edit A Setting';
                        break;
                    }
                    default: {
                        $this->pageTitle = 'Settings Management';
                    }
                }
                break;
            }
            case 'seo-meta': {
                $this->scripts =
                HTML::script('_admin/js/seo.js');

                switch($this->segment3) {
                    case 'add': {
                        $this->pageTitle = 'Add New Meta';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit Meta';
                        break;
                    }
                    default: {
                        $this->pageTitle = 'SEO Meta Mangement';
                    }
                }
                break;
            }
            default: {
                $this->pageTitle = 'Dashboard Management';
            }
        }
    }
    public function loadPageResouces() {
        /* User Resources */
        $this->pageTitle = 'ミャンマー生活情報サイトPOSTE（ポステ）';
        $this->scripts = HTML::script('www/js/main.js');
        // Adver
        $ad_home_pc_top_list = AdPosition::getAdListShow(1, 1);
        $this->data['ad_home_pc_top_list'] = $ad_home_pc_top_list;
        switch($this->segment) {
            // Top page Resources
            case '': {
                $this->pageTitle = 'ヤンゴンの生活情報サイトPOSTE｜ミャンマー生活の新基準';
                $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
                $this->pageKeywords = 'ミャンマー,ヤンゴン,治安,料理,言語,通貨,物価,首都,人,ミャンマー語,英語,旅行';
                $this->stylesheets .=
                HTML::style('www/css/toppage.css');
                // Ad_List
                $ad_home_pc_aside_top_l_list = AdPosition::getAdListShow(2, 1);
                $ad_home_pc_aside_top_m_list = AdPosition::getAdListShow(3, 4);
                $ad_home_pc_bottom_list = AdPosition::getAdListShow(4, 2);
                $ad_home_mobile_top_list = AdPosition::getAdListShow(5, 1);
                // Mobile center have 2 position is above and under lifetips section
                $ad_home_mobile_center_list = AdPosition::getAdListShow(6, 2);
                $this->data['ad_home_pc_aside_top_l_list'] = $ad_home_pc_aside_top_l_list;
                $this->data['ad_home_pc_aside_top_m_list'] = $ad_home_pc_aside_top_m_list;
                $this->data['ad_home_pc_bottom_list'] = $ad_home_pc_bottom_list;
                $this->data['ad_home_mobile_top_list'] = $ad_home_mobile_top_list;
                $this->data['ad_home_mobile_center_list'] = $ad_home_mobile_center_list;
                break;
            }
            // Term Of Use Route
            case 'term-of-use': {
                $this->pageTitle = 'ユーザー登録に関してのお約束 | ベトナム生活情報コミュニティサイトPOSTE(ポステ)';
                break;
            }
            case 'login': {
                $this->pageTitle = 'Login | Poste Myanmar';
                break;
            }
            case 'register': {
                $this->stylesheets .=
                HTML::style('vendors/select2/css/select2.min.css').
                HTML::style('vendors/pretty-checkbox/pretty-checkbox.min.css').
                HTML::style('vendors/bootstrap4-datetimepicker/css/bootstrap-datetimepicker.min.css');
                $this->scripts .=
                HTML::script('vendors/select2/js/select2.min.js').
                HTML::script('js/moment.min.js').
                HTML::script('vendors/bootstrap4-datetimepicker/js/bootstrap-datetimepicker.min.js');
                $this->pageTitle = 'Sign up an Account';
                break;
            }
            case 'active-account': {
                $this->pageTitle = 'Active Account Page';
                break;
            }
            case 'redirect': {
                $this->pageTitle = 'Redirect Page | '.$this->pageTitle;
                break;
            }
            case 'advertisement': {
                $this->pageTitle = 'Advertisement Page';
                $this->pageDescription = '';
                $this->pageKeywords = '';

                $this->stylesheets .= HTML::style('www/css/advertisement.css');
                break;
            }
            // User Dailyinfo Resources
            case 'dailyinfo': {
                // Ad
                $this->data['ad_dailyinfo_mobile_top_banner'] = AdPosition::getAdListShow(8, 1);
                $this->scripts .=
                HTML::script('www/js/dailyinfo.js');
                $this->stylesheets .=
                HTML::style('www/css/dailyinfo.css');
                switch($this->segment2) {
                    case '': {
                        $this->pageTitle = 'Dailyinfo Page';
                        break;
                    }
                    case 'category': {
                        $this->pageTitle = 'Dailyinfo Category Page';
                        break;
                    }
                    default: {
                        $this->stylesheets .= HTML::style('vendors/ckeditor4/plugins/styles/release.css');
                    }
                }
                break;
            }
            // User Lifetip Resources
            case 'lifetip': {
                $this->stylesheets .=
                HTML::style('www/css/lifetip.css');
                $this->scripts .=
                HTML::script('www/js/lifetip.js');
                switch($this->segment2) {
                    case '': {
                        $this->pageTitle = 'Lifetip Page';
                        break;
                    }
                    case 'category': {
                        $this->pageTitle = 'Second Page';
                        break;
                    }
                    default: {
                        $this->stylesheets .= HTML::style('vendors/ckeditor4/plugins/styles/release.css');
                    }
                }
                break;
            }
            // User Golf Resources
            case 'golf': {
                $this->stylesheets .=
                HTML::style('www/css/golf.css');
                switch($this->segment2) {
                    case '': {
                        $this->pageTitle = 'ミャンマー・ヤンゴンのゴルフ場【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンのゴルフ情報ページ。おすすめゴルフ場や練習場、料金などの情報が充実。キャディへのチップの相場額や服装、予約方法などミャンマーのゴルフ事情も満載です【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,ゴルフ,練習場,料金,1人,おすすめ,打ちっぱなし';
                        break;
                    }
                    default: {
                        $this->stylesheets .=
                        HTML::style('vendors/magnific-popup/magnific-popup.css');
                        $this->scripts .=
                        HTML::script('vendors/magnific-popup/jquery.magnific-popup.min.js').
                        HTML::script('www/js/golf.js');
                    }
                }
                break;
            }
            // User Golf Shop Resources
            case 'golf-shop': {
                $this->stylesheets .=
                HTML::style('www/css/golf.css');
                break;
            }
            // User Business Resources
            case 'business': {
                $this->stylesheets .=
                HTML::style('www/css/business/business.css');
                $this->scripts .=
                HTML::script('www/js/business/business.js');
                switch($this->segment2) {
                    case '': {
                        $this->pageTitle = 'Business Page';
                        break;
                    }
                    case 'new':
                    case 'edit': {
                        $this->stylesheets .=
                        HTML::style('vendors/select2/css/select2.min.css').
                        HTML::style('vendors/magnific-popup/magnific-popup.css').
                        HTML::style('www/css/business/business-update.css');
                        $this->scripts .=
                        HTML::script('vendors/select2/js/select2.min.js').
                        HTML::script('vendors/magnific-popup/jquery.magnific-popup.min.js').
                        HTML::script('www/js/business/business-add-field.js').
                        HTML::script('www/js/business/business-update.js');
                        break;
                    }
                    default: {
                        $this->stylesheets .=
                        HTML::style('vendors/magnific-popup/magnific-popup.css');
                        $this->scripts .=
                        HTML::script('vendors/magnific-popup/jquery.magnific-popup.min.js');
                        $this->pageTitle = 'Business Detail Page';
                    }
                }
                break;
            }
            // User Poste Town Resources
            case 'town': {
                switch($this->segment2) {
                    case '': {
                        $this->stylesheets .=
                        HTML::style('www/css/town/town.css');
                        $this->scripts .=
                        HTML::script('www/js/town/town.js');
                        $this->pageTitle = 'Poste Town Page';
                        break;
                    }
                    case 'new':
                    case 'edit': {
                        $this->stylesheets .=
                        HTML::style('vendors/pretty-checkbox/pretty-checkbox.min.css').
                        HTML::style('vendors/select2/css/select2.min.css').
                        HTML::style('vendors/bootstrap-fileinput/css/fileinput.min.css').
                        HTML::style('vendors/bootstrap4-datetimepicker/css/bootstrap-datetimepicker.min.css').
                        HTML::style('www/css/town/town.css').
                        HTML::style('www/css/town/town-detail.css');
                        $this->scripts .=
                        HTML::script('vendors/select2/js/select2.min.js').
                        HTML::script('vendors/bootstrap-fileinput/js/fileinput.min.js').
                        HTML::script('vendors/bootstrap-fileinput/themes/fas/theme.min.js').
                        HTML::script('js/moment.min.js').
                        HTML::script('vendors/bootstrap4-datetimepicker/js/bootstrap-datetimepicker.min.js').
                        HTML::script('vendors/magnific-popup/jquery.magnific-popup.min.js').
                        HTML::script('www/js/town/town.js').
                        HTML::script('www/js/town/town-add-field.js').
                        HTML::script('www/js/town/town-update.js');
                        break;
                    }
                    default: {
                        $this->stylesheets .=
                        HTML::style('vendors/magnific-popup/magnific-popup.css').
                        HTML::style('www/css/town/town.css').
                        HTML::style('www/css/town/town-detail.css');
                        $this->scripts .=
                        HTML::script('vendors/magnific-popup/jquery.magnific-popup.min.js').
                        HTML::script('www/js/town/town.js');
                    }
                }
                break;
            }
            // User cinema Resources
            case 'cinema': {
                $this->pageTitle = 'ミャンマー・ヤンゴンの最新映画情報｜上映スケジュールや映画館の情報も紹介【POSTE】';
                $this->pageDescription = 'ミャンマー・ヤンゴンでおすすめの映画館や映画の上映スケジュール、料金などを紹介します。日本でお馴染みのあの最新作品の情報もあるので、映画好きは要チェックです!!【ポステ】';
                $this->pageKeywords = 'ミャンマー,ヤンゴン,映画館,映画,料金,スケジュール,上映中,日本';
                $this->stylesheets .=
                HTML::style('www/css/cinema.css');
                $this->scripts .=
                HTML::script('www/js/cinema.js');
                break;
            }
            // User Personal Trading Resources
            case 'personal-trading': {
                $this->pageTitle = 'ミャンマー・ヤンゴンで個人時売なら【POSTE】の情報掲示板';
                $this->pageDescription = 'ミャンマー・ヤンゴン在住者向けの個人売買掲示板。ミャンマー生活でいらなくなった家具や電化製品の販売、ミャンマー生活で必要な物の購入をすることができます。【ポステ】';
                $this->pageKeywords = 'ミャンマー,ヤンゴン,バイク,冷蔵庫,掃除機,タンス,電子ピアノ,ミャンマー生活,クラシファイド';
                switch($this->segment2) {
                    case 'new-post':
                    case 'edit-post': {
                        $this->stylesheets .=
                        HTML::style('vendors/pretty-checkbox/pretty-checkbox.min.css').
                        HTML::style('vendors/bootstrap-fileinput/css/fileinput.min.css').
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('vendors/ckeditor4/ckeditor.js').
                        HTML::script('vendors/bootstrap-fileinput/js/fileinput.min.js').
                        HTML::script('vendors/bootstrap-fileinput/themes/fas/theme.min.js').
                        HTML::script('www/js/classify.js');
                        break;
                    }
                    case '': {
                        $this->stylesheets .=
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('www/js/classify.js');
                        break;
                    }
                    case 'list': {
                        $this->stylesheets .=
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('www/js/classify.js');
                        break;
                    }
                    default: {
                        $this->stylesheets .=
                        HTML::style('vendors/magnific-popup/magnific-popup.css') .
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('vendors/magnific-popup/jquery.magnific-popup.min.js') .
                        HTML::script('www/js/classify.js');
                    }
                }
                break;
            }
            // Real Estate
            case 'real-estate': {
                $this->pageTitle = 'ミャンマー・ヤンゴンの不動産情報なら【POSTE】の情報掲示板';
                $this->pageDescription = 'ミャンマー・ヤンゴンでお部屋探しに困った時は【ポステ】の情報掲示板の利用をオススメします!!  アパート・サービスアパート・戸建て・レンタルオフィスと物件情報満載です。【ポステ】';
                $this->pageKeywords = 'ミャンマー,ヤンゴン,お部屋探し,クラシファイド, アパート,サービスアパート,戸建て,レンタルオフィス';
                switch($this->segment2) {
                    case 'new-post':
                    case 'edit-post': {
                        $this->stylesheets .=
                        HTML::style('vendors/pretty-checkbox/pretty-checkbox.min.css') .
                        HTML::style('vendors/bootstrap-fileinput/css/fileinput.min.css') .
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('vendors/ckeditor4/ckeditor.js') .
                        HTML::script('vendors/bootstrap-fileinput/js/fileinput.min.js') .
                        HTML::script('vendors/bootstrap-fileinput/themes/fas/theme.min.js') .
                        HTML::script('www/js/classify.js');
                        break;
                    }
                    case '': {
                        $this->stylesheets .=
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('www/js/classify.js');
                        break;
                    }
                    case 'list': {
                        $this->stylesheets .=
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('www/js/classify.js');
                        break;
                    }
                    default: {
                        $this->stylesheets .=
                        HTML::style('vendors/magnific-popup/magnific-popup.css') .
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('vendors/magnific-popup/jquery.magnific-popup.min.js') .
                        HTML::script('www/js/classify.js');
                    }
                }
                break;
            }
            //Job Searching
            case 'job-searching': {
                $this->pageTitle = 'ミャンマー・ヤンゴンで仕事探しなら【POSTE】の情報掲示板';
                $this->pageDescription = 'ミャンマー・ヤンゴンでの求職者・求人者向けのお仕事探し掲示板。ミャンマーで仕事探しをしている方や仕事を募集している方におすすめです。 営業・不動産・コンサル・企画・事務・通訳・ITなどの求人情報満載です。【ポステ】';
                $this->pageKeywords = 'ミャンマー,ヤンゴン,クラシファイド,営業,不動産,コンサル,企画,事務,通訳,IT';
                switch($this->segment2) {
                    case 'new-post':
                    case 'edit-post': {
                        $this->stylesheets .=
                        HTML::style('vendors/pretty-checkbox/pretty-checkbox.min.css').
                        HTML::style('vendors/bootstrap4-datetimepicker/css/bootstrap-datetimepicker.min.css').
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('vendors/ckeditor4/ckeditor.js').
                        HTML::script('js/moment.min.js').
                        HTML::script('vendors/bootstrap4-datetimepicker/js/bootstrap-datetimepicker.min.js').
                        HTML::script('www/js/classify.js');
                        break;
                    }
                    case '': {
                        $this->stylesheets .=
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('www/js/classify.js');
                        break;
                    }
                    case 'list': {
                        $this->stylesheets .=
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('www/js/classify.js');
                        break;
                    }
                    default: {
                        $this->stylesheets .=
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('www/js/classify.js');
                    }
                }
                break;
            }
            //Bullboard
            case 'bullboard': {
                $this->pageTitle = 'ミャンマー・ヤンゴンの情報掲示板なら【POSTE】の情報掲示板';
                $this->pageDescription = 'ミャンマー・ヤンゴンで情報掲示板ページ。「サークルのメンバーを募集」「ミャンマー語を教えてくれる先生を募集」など、使い方は無限大!!【ポステ】';
                $this->pageKeywords = 'ミャンマー,ヤンゴン,クラシファイド,営業,不動産,コンサル,企画,事務,通訳,IT';
                switch($this->segment2) {
                    case 'new-post':
                    case 'edit-post': {
                        $this->stylesheets .=
                        HTML::style('vendors/pretty-checkbox/pretty-checkbox.min.css').
                        HTML::style('vendors/bootstrap-fileinput/css/fileinput.min.css').
                        HTML::style('vendors/bootstrap4-datetimepicker/css/bootstrap-datetimepicker.min.css').
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('vendors/ckeditor4/ckeditor.js').
                        HTML::script('vendors/bootstrap-fileinput/js/fileinput.min.js').
                        HTML::script('vendors/bootstrap-fileinput/themes/fas/theme.min.js').
                        HTML::script('js/moment.min.js').
                        HTML::script('vendors/bootstrap4-datetimepicker/js/bootstrap-datetimepicker.min.js').
                        HTML::script('www/js/classify.js');
                        break;
                    }
                    case '': {
                        $this->stylesheets .=
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('www/js/classify.js');
                        break;
                    }
                    case 'list': {
                        $this->stylesheets .=
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('www/js/classify.js');
                        break;
                    }
                    default: {
                        $this->stylesheets .=
                        HTML::style('vendors/magnific-popup/magnific-popup.css').
                        HTML::style('www/css/classify.css');
                        $this->scripts .=
                        HTML::script('vendors/magnific-popup/jquery.magnific-popup.min.js').
                        HTML::script('www/js/classify.js');
                    }
                }
                break;
            }
        }
    }
    public function loadPageInfoFromChild($type, $info = 0, $article = null) {
        switch($type) {
            // DAilyinfo
            case 'dailyinfo': {
                switch($info) {
                    // category
                    case 1: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの社会ニュース【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンで起こる事件やデモなどの【社会ニュース】、株価や為替、選挙などの【政治・経済ニュース】、天気や治安、物価の変動などの【生活ニュース】、アイドルやお笑い芸人などの【エンタメニュース】、ビジネスニュースなど、日本人が知っておきたい現地ニュースを日本語で配信します!!【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,ニュース,社会,生活,政治,経済,政治・経済,デモ,事件,エンタメ';
                        break;
                    }
                    case 2: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの政治・経済ニュース【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンで起こる事件やデモなどの【社会ニュース】、株価や為替、選挙などの【政治・経済ニュース】、天気や治安、物価の変動などの【生活ニュース】、アイドルやお笑い芸人などの【エンタメニュース】、ビジネスニュースなど、日本人が知っておきたい現地ニュースを日本語で配信します!!【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,ニュース,社会,生活,政治,経済,政治・経済,デモ,事件,エンタメ';
                        break;
                    }
                    case 3: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの生活ニュース【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンで起こる事件やデモなどの【社会ニュース】、株価や為替、選挙などの【政治・経済ニュース】、天気や治安、物価の変動などの【生活ニュース】、アイドルやお笑い芸人などの【エンタメニュース】、ビジネスニュースなど、日本人が知っておきたい現地ニュースを日本語で配信します!!【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,ニュース,社会,生活,政治,経済,政治・経済,デモ,事件,エンタメ';
                        break;
                    }
                    case 4: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンのエンタメニュース【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンで起こる事件やデモなどの【社会ニュース】、株価や為替、選挙などの【政治・経済ニュース】、天気や治安、物価の変動などの【生活ニュース】、アイドルやお笑い芸人などの【エンタメニュース】、ビジネスニュースなど、日本人が知っておきたい現地ニュースを日本語で配信します!!【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,ニュース,社会,生活,政治,経済,政治・経済,デモ,事件,エンタメ';
                        break;
                    }
                    case 5: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの耳寄り情報｜レストランやスパのお得な割引情報が満載【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンの在住者には嬉しい耳寄り情報を紹介します。レストランやスパ、カフェなどのオトクな割引情報が満載です。【ポステ】';
                        $this->pageKeywords = 'レストラン,スパミャンマー,ヤンゴン,マッサージ,旅行,移住,生活';
                        break;
                    }
                    case 6: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンのイベント情報【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンのイベントスケジュールを紹介します。ハロウィンやクリスマス、カウントダウン、年越し、クメール正月イベントなど情報が盛りだくさんです。【ポステ】';
                        $this->pageKeywords = '年越し,カウントダウン,クリスマス,ハロウィン,年越し';
                        break;
                    }
                    // Detail Page
                    default: {
                        if(!is_null($article)) {
                            $this->pageTitle = $article->name.' | '.$this->pageTitle;
                            $this->pageType = 'article';
                            $this->pageImage = Base::getUploadURL($article->getThumbnail->name, $article->getThumbnail->dir);
                            $this->pageDescription = $article->description;
                            $this->pageKeywords = $article->keywords;
                        }
                    }
                }
                break;
            }
            // Lifetip
            case 'lifetip': {
                switch($info) {
                    case 7: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの生活基本情報コンテンツ【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンの生活情報ページ。ミャンマー・ヤンゴンの生活費や物価、治安、交通手段など生活基本情報からレストランなどのグルメ情報、病院情報、スパ・マッサージ情報、日系幼稚園や日本人学校、学習塾などの教育情報情報まで、ミャンマー生活に必要な情報が全てまとまっています。【ポステ】';
                        $this->pageKeywords = 'ミャンマー,生活基本, 言語,通貨,治安,物価,ビザ,大使館,交通手段,環境問題,チップの有無';
                        break;
                    }
                    case 8: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンのグルメ情報コンテンツ【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンのグルメ情報ページ。日本食料理（和食）やフレンチ、イタリアン、韓国料理、中華、インド料理、地中海料理などの情報が満載です。ローカルレストランの情報も充実。【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,グルメ,日本食料理（和食）,フレンチ,イタリアン,韓国料理,中華,インド料理,地中海料理,おすすめ';
                        break;
                    }
                    case 9: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの医療情報コンテンツ【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンの医療情報ページ。ミャンマーで気をつけるべき病気やミャンマーの医療保険、予防接種、日本語対応可能な病院などの情報がまとまっています。【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,医療,内科,歯科,外科,耳鼻科';
                        break;
                    }
                    case 10: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの美容健康情報コンテンツ【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンで日本人に人気のスパ・マッサージ、日系美容院、ジム・フィットネス、ネイルサロンの事情やミャンマーの美容事情を紹介します。【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,美容健康情報,スパ,マッサージ,美容院,フィットネス,ネイルサロン,おすすめ';
                        break;
                    }
                    case 11: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの交通情報コンテンツ【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンの交通情報ページ。バイクタクシーの利用方法や料金、バイク購入価格、免許の取り方、事故率など交通に関する情報を紹介します。【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,交通情報,バイクタクシー,利用方法,料金,バイク,購入価格,免許の取り方,事故率';
                        break;
                    }
                    case 12: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの教育情報コンテンツ【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンの教育情報ページ。幼稚園・小学校・中学校・大学などの学校のことや語学学校・子どもの習い事教室の情報を紹介します。【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,教育情報,幼稚園,小学校,中学校,大学,語学学校,子ども,習い事';
                        break;
                    }
                    case 13: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの観光情報コンテンツ【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンの観光情報ページ。観光時期や観光名所、観光ツアー、ツアー料金などまとめて紹介します。【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,観光情報,観光シーズン,観光ツアー,ツアー料金';
                        break;
                    }
                    case 14: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの夜遊び情報コンテンツ【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンの夜遊び情報ページ。カラオケ・ディスコ・クラブ・ラウンジ・バー・キャバクラなどの情報満載です。【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,カラオケ,ディスコ,クラブ,ラウンジ,バー,キャバクラ';
                        break;
                    }
                    case 15: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの買い物情報コンテンツ【POSTE】';
                        $this->pageDescription = 'ミャンマー・ヤンゴンの買い物情報ページ。雑貨やブランド服、コンビニ、市場など在住者も観光客も知りたい情報満載です。【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,買い物,アクセサリー,雑貨,ブランド服,コンビニ,市場';
                        break;
                    }
                    case 16: {
                        $this->pageTitle = 'ミャンマー・ヤンゴンの文化情報コンテンツ【POSTE】';
                        $this->pageDescription = 'カミャンマー・ヤンゴンの文化情報ページ。ミャンマーで生活すると、文化の違いを感じることがよくあります。ミャンマー人の習慣や特徴など、ミャンマーに住むポステスタッフが紹介します。【ポステ】';
                        $this->pageKeywords = 'ミャンマー,ヤンゴン,ミャンマー生活,文化の違い,ミャンマー人,習慣,特徴';
                        break;
                    }
                    // Detail Page
                    default: {
                        if(!is_null($article)) {
                            $this->pageTitle = $article->name.' | '.$this->pageTitle;
                            $this->pageType = 'article';
                            $this->pageImage = Base::getUploadURL($article->getThumbnail->name, $article->getThumbnail->dir);
                            $this->pageDescription = $article->description;
                            $this->pageKeywords = $article->keywords;
                        }
                    }
                }
                break;
            }
            // Golf - Golf Shop
            case 'golf': {
                if(!is_null($article)) {
                    $this->pageTitle = $article->name.' | '.$this->pageTitle;
                    $this->pageType = 'article';
                    $this->pageImage = Base::getUploadURL($article->getThumbnail->name, $article->getThumbnail->dir);
                    $this->pageDescription = $article->description;
                    $this->pageKeywords = $article->keywords;
                }
                break;
            }
            // Personal Trading
            case 'personal-trading': {
                switch($info) {
                    case 'add': {
                        $this->pageTitle = 'Add New Personal Trading';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit Personal Trading';
                        break;
                    }
                    default: {
                        if(!is_null($article)) {
                            $this->pageTitle = $article->name . ' | '. $this->pageTitle;
                        }
                    }
                }
                break;
            }
            // RealEstate
            case 'real-estate': {
                switch($info) {
                    case 'add': {
                        $this->pageTitle = 'Add New RealEstate';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit RealEstate';
                        break;
                    }
                    default: {
                        if(!is_null($article)) {
                            $this->pageTitle = $article->name . ' | '. $this->pageTitle;
                        }
                    }
                }
                break;
            }
            // Job Searching
            case 'job-searching': {
                switch($info) {
                    case 'add': {
                        $this->pageTitle = 'Add New Job Searching';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit Job Searching';
                        break;
                    }
                    default: {
                        if(!is_null($article)) {
                            $this->pageTitle = $article->name . ' | '. $this->pageTitle;
                        }
                    }
                }
                break;
            }
            // Bullboard
            case 'bullboard': {
                switch($info) {
                    case 'add': {
                        $this->pageTitle = 'Add New Bullboard';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit Bullboard';
                        break;
                    }
                    default: {
                        if(!is_null($article)) {
                            $this->pageTitle = $article->name . ' | '. $this->pageTitle;
                        }
                    }
                }
                break;
            }
            // Poste Town
            case 'poste-town': {
                switch($info) {
                    case 'add': {
                        $this->pageTitle = 'Add New Town Article';
                        break;
                    }
                    case 'edit': {
                        $this->pageTitle = 'Edit Town Article';
                        break;
                    }
                    case 'category': {
                        switch($article) {
                            case 0: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンのおすすめ店舗一覧【POSTE】';
                                $this->pageDescription = 'ミャンマー・ヤンゴンでおすすめの店舗情報を紹介します。レストランやスパ、ホテルなど現地情報満載です◎';
                                $this->pageKeywords = 'ミャンマー,ヤンゴン,おすすめ,店舗,飲食店,ショッピング,レストラン,ホテル,塾,観光,習い事,サービス,';
                                break;
                            }
                            case 68: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンの飲食店舗一覧【POSTE】';
                                $this->pageDescription = 'ミャンマー・ヤンゴンでおすすめの飲食店情報を紹介します。日本食、ミャンマー料理、韓国料理、イタリアン、フレンチ、タイ料理など様々なレストラン情報を知ることができるのはポステだけ!!';
                                $this->pageKeywords = 'ヤンゴン,日本食,和食,寿司,魚料理,ラーメン,丼もの,揚げ物,粉物,お好み焼き,郷土料理,アジア料理,エスニック料理,中華,イタリアン,フレンチ,ステーキ,焼き鳥,鍋,しゃぶしゃぶ,すき焼き,居酒屋,バー,ビュッフェ,イタリアン,フレンチ,韓国料理,中華,ミャンマー料理';
                                break;
                            }
                            case 69: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンのショッピング店舗一覧【POSTE】';
                                $this->pageDescription = 'ミャンマー・ヤンゴンでおすすめのショッピング施設を紹介します。ロンジーやタナカなどミャンマー土産にピッタリな施設情報も知れるのはポステだけ!!';
                                $this->pageKeywords = 'ヤンゴン,土産,買い物,ショッピング';
                                break;
                            }
                            case 70: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンの宿泊施設一覧【POSTE】';
                                $this->pageDescription = 'ミャンマー・ヤンゴンでおすすめの宿泊施設情報を紹介します。1日から利用可能なアパートから長期主張社向けのホテルまで役立つ情報が盛りだくさんです。';
                                $this->pageKeywords = 'ヤンゴン,ホテル,ペンション,ホステル,安い,高い,日系';
                                break;
                            }
                            case 71: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンの宿泊施設一覧【POSTE】';
                                $this->pageDescription = 'ミャンマー・ヤンゴンでおすすめの美容施設を紹介します。人気のスパやマッサージ、美容室、エステなどの情報が盛りだくさんです◎';
                                $this->pageKeywords = 'ヤンゴン,美容室,ネイル,マッサージ,エステ,スパ';
                                break;
                            }
                            case 72: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンのナイトスポット施設一覧【POSTE】';
                                $this->pageDescription = 'ミャンマー・ヤンゴンのナイトスポット情報を紹介します。ナイトクラブやディスコ、バー、カラオケなどの情報が満載です◎';
                                $this->pageKeywords = 'ヤンゴン,クラブ,ディスコ,ガールズバー,カラオケ,ナイトクラブ';
                                break;
                            }
                            case 73: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンの娯楽施設一覧【POSTE】';
                                $this->pageDescription = 'ミャンマー・ヤンゴンの娯楽施設情報を紹介します。ゴルフ場や釣り堀など、子供から大人まで楽しめる施設情報が盛りだくさんです。';
                                $this->pageKeywords = 'ヤンゴン,ゴルフ場,釣場,遊び場,娯楽';
                                break;
                            }
                            case 74: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンの医療施設一覧【POSTE】';
                                $this->pageDescription = 'ミャンマー・ヤンゴンの医療施設情報を紹介します。万が一の事態にそなえ、病院の情報や診療科目をしっかりと把握しておきましょう。';
                                $this->pageKeywords = 'ヤンゴン,病院,クリニック,医療';
                                break;
                            }
                            case 75: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンの観光施設一覧【POSTE】';
                                $this->pageDescription = 'ミャンマー・ヤンゴンの観光施設情報やツアー会社の情報を紹介します。';
                                $this->pageKeywords = 'ヤンゴン,観光,ツアー';
                                break;
                            }
                            case 76: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンの教育施設一覧【POSTE】';
                                $this->pageDescription = 'ミャンマー・ヤンゴンの現地学校や塾の情報などを紹介します。';
                                $this->pageKeywords = 'ヤンゴン,教育,学校';
                                break;
                            }
                            case 77: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンの習い事施設一覧【POSTE】';
                                $this->pageDescription = 'ミャンマー・ヤンゴンでバレエや水泳、ダンス、ピアノなどの習い事をしたい方へ、POSTEがおすすめの習い事教室をまとめて紹介します。';
                                $this->pageKeywords = 'ヤンゴン,習い事,バレエ,水泳,ダンス,ピアノ';
                                break;
                            }
                            case 78: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンのその他のサービス【POSTE】';
                                $this->pageDescription = 'ミャンマー・ヤンゴンでお探しのサービスがある方は要チェック!';
                                $this->pageKeywords = 'ヤンゴン,サービス';
                                break;
                            }
                        }
                        break;
                    }
                    case 'tag': {
                        $this->pageTitle = $article[0].' | Poste Town';
                        break;
                    }
                    default: {
                        if(!is_null($article)) {
                            $this->pageTitle = $article->name . ' | ミャンマーで'.$article->getCategory->name;
                            $this->pageKeywords = $article->name.','.$article->getCategory->name.',ミャンマーで';
                            $this->pageDescription = $article->description;
                        }
                    }
                }
                break;
            }
            // Business
            case 'business': {
                switch ($info) {
                    case 'category':  {
                        switch ($article) {
                            case 0: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンのビジネスページ【POSTE】';
                                $this->pageDescription = '日系企業の進出が相次ぐミャンマー。日本語の情報不足でビジネスチャンスを逃していませんか？ ポステが在ミャンマー企業とミャンマー進出予定の日系企業のプラットフォームとなり、ビジネスチャンスを拡大させます。ポステに登録されている企業の種類は総務全般（通訳・翻訳、市場調査、印刷会社、事務用品、会計・税務）、生活基盤（鉄鋼、化学、インフラ、生活産業）、インターネット関連、コンサルティング（法律事務所、進出支援、人材派遣、オフィス内装、インテリアデザイン）、製造業（電子機器、自動車・自動車関連部品、鉄鋼・金属、材木 、製紙・パルプ、製薬、繊維、工具・設備、ガラス製造、プラスチック・ゴム、重機）';
                                $this->pageKeywords = 'ヤンゴン,ビジネス,総務全般,通訳,翻訳,市場調査,印刷会社,事務用品,会計,税務,生活基盤,鉄鋼,化学,インフラ,生活産業,インターネット関連,コンサルティング,法律事務所,進出支援,人材派遣,オフィス内装,インテリアデザイン,製造業,電子機器,自動車,自動車関連部品,鉄鋼,金属,材木 ,製紙,パルプ,製薬,繊維,工具,設備,ガラス製造,プラスチック,ゴム,重機,メーカー,物流,金融';
                                break;
                            }
                            case 17: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンの総務企業一覧【POSTE】';
                                $this->pageDescription = '日系企業の進出が相次ぐミャンマー。日本語の情報不足でビジネスチャンスを逃していませんか？ ポステに登録されてい総務企業（通訳・翻訳、市場調査、印刷会社、事務用品、会計・税務など）を紹介します。';
                                $this->pageKeywords = 'ヤンゴン,ビジネス,総務全般,通訳,翻訳,市場調査,印刷会社,事務用品,会計,税務,生活基盤,鉄鋼,化学,インフラ,生活産業,インターネット関連,コンサルティング,法律事務所,進出支援,人材派遣,オフィス内装,インテリアデザイン,製造業,電子機器,自動車,自動車関連部品,鉄鋼,金属,材木 ,製紙,パルプ,製薬,繊維,工具,設備,ガラス製造,プラスチック,ゴム,重機,メーカー,物流,金融';
                                break;
                            }
                            case 18: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンの生活基盤企業一覧【POSTE】';
                                $this->pageDescription = '日系企業の進出が相次ぐミャンマー。日本語の情報不足でビジネスチャンスを逃していませんか？ ポステに登録されている生活基盤（鉄鋼、化学、インフラ、生活産業など）を紹介します。';
                                $this->pageKeywords = 'ヤンゴン,ビジネス,総務全般,通訳,翻訳,市場調査,印刷会社,事務用品,会計,税務,生活基盤,鉄鋼,化学,インフラ,生活産業,インターネット関連,コンサルティング,法律事務所,進出支援,人材派遣,オフィス内装,インテリアデザイン,製造業,電子機器,自動車,自動車関連部品,鉄鋼,金属,材木 ,製紙,パルプ,製薬,繊維,工具,設備,ガラス製造,プラスチック,ゴム,重機,メーカー,物流,金融';
                                break;
                            }
                            case 19: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンのIT企業一覧【POSTE】';
                                $this->pageDescription = '日系企業の進出が相次ぐミャンマー。日本語の情報不足でビジネスチャンスを逃していませんか？ ポステに登録されているIT企業一覧を紹介します。';
                                $this->pageKeywords = 'ヤンゴン,ビジネス,総務全般,通訳,翻訳,市場調査,印刷会社,事務用品,会計,税務,生活基盤,鉄鋼,化学,インフラ,生活産業,インターネット関連,コンサルティング,法律事務所,進出支援,人材派遣,オフィス内装,インテリアデザイン,製造業,電子機器,自動車,自動車関連部品,鉄鋼,金属,材木 ,製紙,パルプ,製薬,繊維,工具,設備,ガラス製造,プラスチック,ゴム,重機,メーカー,物流,金融';
                            }
                            case 20: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンのコンサルティング企業一覧【POSTE】';
                                $this->pageDescription = '日系企業の進出が相次ぐミャンマー。日本語の情報不足でビジネスチャンスを逃していませんか？ ポステに登録されているコンサルティング企業（法律事務所、進出支援、人材派遣、オフィス内装、インテリアデザインなど）一覧を紹介します。';
                                $this->pageKeywords = 'ヤンゴン,ビジネス,総務全般,通訳,翻訳,市場調査,印刷会社,事務用品,会計,税務,生活基盤,鉄鋼,化学,インフラ,生活産業,インターネット関連,コンサルティング,法律事務所,進出支援,人材派遣,オフィス内装,インテリアデザイン,製造業,電子機器,自動車,自動車関連部品,鉄鋼,金属,材木 ,製紙,パルプ,製薬,繊維,工具,設備,ガラス製造,プラスチック,ゴム,重機,メーカー,物流,金融';
                            }
                            case 21: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンの製造業関連企業一覧【POSTE】';
                                $this->pageDescription = '日系企業の進出が相次ぐミャンマー。日本語の情報不足でビジネスチャンスを逃していませんか？ ポステに登録されている製造業（電子機器、自動車・自動車関連部品、鉄鋼・金属、材木 、製紙・パルプ、製薬、繊維、工具・設備、ガラス製造、プラスチック・ゴム、重機など）一覧を紹介します。';
                                $this->pageKeywords = 'ヤンゴン,ビジネス,総務全般,通訳,翻訳,市場調査,印刷会社,事務用品,会計,税務,生活基盤,鉄鋼,化学,インフラ,生活産業,インターネット関連,コンサルティング,法律事務所,進出支援,人材派遣,オフィス内装,インテリアデザイン,製造業,電子機器,自動車,自動車関連部品,鉄鋼,金属,材木 ,製紙,パルプ,製薬,繊維,工具,設備,ガラス製造,プラスチック,ゴム,重機,メーカー,物流,金融';
                            }
                            case 22: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンの金融関連企業一覧【POSTE】';
                                $this->pageDescription = '日系企業の進出が相次ぐミャンマー。日本語の情報不足でビジネスチャンスを逃していませんか？ ポステに登録されている金融関連企業一覧を紹介します。';
                                $this->pageKeywords = 'ヤンゴン,ビジネス,総務全般,通訳,翻訳,市場調査,印刷会社,事務用品,会計,税務,生活基盤,鉄鋼,化学,インフラ,生活産業,インターネット関連,コンサルティング,法律事務所,進出支援,人材派遣,オフィス内装,インテリアデザイン,製造業,電子機器,自動車,自動車関連部品,鉄鋼,金属,材木 ,製紙,パルプ,製薬,繊維,工具,設備,ガラス製造,プラスチック,ゴム,重機,メーカー,物流,金融';
                            }
                            case 23: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンのメーカー関連企業一覧【POSTE】';
                                $this->pageDescription = '日系企業の進出が相次ぐミャンマー。日本語の情報不足でビジネスチャンスを逃していませんか？ ポステに登録されているメーカー関連企業一覧を紹介します。';
                                $this->pageKeywords = 'ヤンゴン,ビジネス,総務全般,通訳,翻訳,市場調査,印刷会社,事務用品,会計,税務,生活基盤,鉄鋼,化学,インフラ,生活産業,インターネット関連,コンサルティング,法律事務所,進出支援,人材派遣,オフィス内装,インテリアデザイン,製造業,電子機器,自動車,自動車関連部品,鉄鋼,金属,材木 ,製紙,パルプ,製薬,繊維,工具,設備,ガラス製造,プラスチック,ゴム,重機,メーカー,物流,金融';
                            }
                            case 24: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンのメーカー物流企業一覧【POSTE】';
                                $this->pageDescription = '日系企業の進出が相次ぐミャンマー。日本語の情報不足でビジネスチャンスを逃していませんか？ ポステに登録されている物流関連企業一覧を紹介します。';
                                $this->pageKeywords = 'ヤンゴン,ビジネス,総務全般,通訳,翻訳,市場調査,印刷会社,事務用品,会計,税務,生活基盤,鉄鋼,化学,インフラ,生活産業,インターネット関連,コンサルティング,法律事務所,進出支援,人材派遣,オフィス内装,インテリアデザイン,製造業,電子機器,自動車,自動車関連部品,鉄鋼,金属,材木 ,製紙,パルプ,製薬,繊維,工具,設備,ガラス製造,プラスチック,ゴム,重機,メーカー,物流,金融';
                            }
                            case 25: {
                                $this->pageTitle = 'ミャンマー・ヤンゴンのーサービス企業一覧【POSTE】';
                                $this->pageDescription = '日系企業の進出が相次ぐミャンマー。日本語の情報不足でビジネスチャンスを逃していませんか？ ポステに登録されているサービス関連企業一覧を紹介します。';
                                $this->pageKeywords = 'ヤンゴン,ビジネス,総務全般,通訳,翻訳,市場調査,印刷会社,事務用品,会計,税務,生活基盤,鉄鋼,化学,インフラ,生活産業,インターネット関連,コンサルティング,法律事務所,進出支援,人材派遣,オフィス内装,インテリアデザイン,製造業,電子機器,自動車,自動車関連部品,鉄鋼,金属,材木 ,製紙,パルプ,製薬,繊維,工具,設備,ガラス製造,プラスチック,ゴム,重機,メーカー,物流,金融';
                            }
                        }
                        break;
                    }

                    default:
                    if(!is_null($article)) {
                        $this->pageTitle = $article->name.' | ミャンマーで';
                        $this->pageDescription = $article->description;
                        $this->pageKeywords = $article->name.',ミャンマーで';
                        foreach ($article->getCategories as $key => $cate) {
                            if($key != 0) {
                                $this->pageTitle .= '-';
                            } else {
                                $this->pageTitle .= ' | ';
                            }
                            $this->pageTitle .= $cate->name;
                            $this->pageKeywords .= ','.$cate->name;
                        }
                    }
                    break;
                }
                break;
            }
        }
        $this->data['pageTitle'] = $this->pageTitle;
        $this->data['pageDescription'] = $this->pageDescription;
        $this->data['pageKeywords'] = $this->pageKeywords;
        $this->data['pageType'] = $this->pageType;
        $this->data['pageImage'] = $this->pageImage;
        $this->data['pageKeywords'] = $this->pageKeywords;
    }

    public function loadMetaTagContent() {
        $full_url = trim(Request()->fullUrl(), '/');

        $meta = Meta::withTrashed()->where('url', $full_url)->first();

        if(!is_null($meta)) {
            $this->pageTitle =  $meta->title;
            $this->pageDescription = $meta->description;
            $this->pageKeywords = $meta->keywords;
            $this->pageImage = $meta->image;
            $this->pageType = $meta->type;
        }
    }

    /**
    * Get News or Promotion, Event view Ranking in 7 days....
    * @param Integer $tag_id : ID of Param
    * @param Integer $category_type: 1: News - 0: Event and Promotion
    */
    public function getNewsRanking($tag_id, $category_type = 1) {
        $dateBefore1Week = date('Y-m-d', strtotime('-7 days'));
        $newsRankingList = News::with('getThumbnail')->whereHas('getCategoryNews', function($query) use($category_type) {
            if($category_type) {
                $query->where('category_id', '<>', News::PROMOTION_CATEGORY_ID)->where('category_id', '<>', News::EVENT_CATEGORY_ID);
            } else {
                $query->whereIn('category_id', array(News::PROMOTION_CATEGORY_ID, News::EVENT_CATEGORY_ID));
            }
        })->where('tag', $tag_id)->whereDate('published_at', '>=', $dateBefore1Week)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('view', 'DESC')->take(5)->get();

        $dateBefore2Week = $dateBefore1Week;

        $last_item = News::with('getThumbnail')->whereHas('getCategoryNews', function($query) use($category_type) {
            if($category_type) {
                $query->where('category_id', '<>', News::PROMOTION_CATEGORY_ID)->where('category_id', '<>', News::EVENT_CATEGORY_ID);
            } else {
                $query->whereIn('category_id', array(News::PROMOTION_CATEGORY_ID, News::EVENT_CATEGORY_ID));
            }
        })->where('tag', $tag_id)->orderBy('view', 'ASC')->first();

        while($newsRankingList->count() < 5) {
            if(!$newsRankingList->isEmpty() && $last_item->id == $newsRankingList->last()->id) {
                break;
            }

            $dateBefore1Week = date('Y-m-d', strtotime('-1 days', strtotime($dateBefore2Week)));
            $dateBefore2Week = date('Y-m-d', strtotime('-7 days', strtotime($dateBefore1Week)));

            $newsRankingSecondList = News::with('getThumbnail')->whereHas('getCategoryNews', function($query) use($category_type) {
                if($category_type) {
                    $query->where('category_id', '<>', News::PROMOTION_CATEGORY_ID)->where('category_id', '<>', News::EVENT_CATEGORY_ID);
                } else {
                    $query->whereIn('category_id', array(News::PROMOTION_CATEGORY_ID, News::EVENT_CATEGORY_ID));
                }
            })->where('tag', $tag_id)->whereBetween('published_at', array($dateBefore2Week, $dateBefore1Week))->orderBy('view', 'DESC')->take(5 - $newsRankingList->count())->get();

            $newsRankingList = $newsRankingList->merge($newsRankingSecondList);
        }

        return $newsRankingList;
    }
}
