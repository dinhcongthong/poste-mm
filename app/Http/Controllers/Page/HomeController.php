<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use DB;

use App\Mail\Contact;

use App\Models\Param;
use App\Models\News;
use App\Models\Category;
use App\Models\PersonalTrading;
use App\Models\JobSearching;
use App\Models\RealEstate;
use App\Models\BullBoard;
use App\Models\District;

class HomeController extends Controller
{
    public function index() {
        // News List
        $dailyinfoTag = Param::getExactParamItem('dailyinfo', 'article');
        $newsList = News::with('getThumbnail')->whereHas('getCategoryNews', function($query) {
            $query->where('category_id', '<>', 5)->where('category_id', '<>', 6);
        })->where('tag', $dailyinfoTag->id)->whereDate('published_at', '<=', date('Y-m-d'))->select(DB::raw('*, TIMESTAMPDIFF(DAY, `published_at`, NOW()) as `datecount`'))->orderBy('published_at', 'DESC')->orderBy('created_at', 'DESC')->take(7)->get();

        // News Ranking from Controller.php parent
        $newsRankingList = $this->getNewsRanking($dailyinfoTag->id);

        // Promotion Event List
        $promotionList = News::with('getThumbnail', 'getCategoryNews')->whereHas('getCategoryNews', function($query) {
            $query->where('category_id', 5)->orWhere('category_id', 6);
        })->where('tag', $dailyinfoTag->id)->whereDate('published_at', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->select(DB::raw('*, TIMESTAMPDIFF(DAY, `published_at`, NOW()) as `datecount`'))->inRandomOrder()->take(3)->get();
        // Promotion Event Raking List
        $promotionRankingList = News::with('getThumbnail', 'getCategoryNews')->whereHas('getCategoryNews', function($query) {
            $query->where('category_id', 5)->orWhere('category_id', 6);
        })->where('tag', $dailyinfoTag->id)->whereYear('published_at', date('Y'))->whereDate('published_at', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->orderBy('view', 'DESC')->take(5)->get();

        // Lifetip List
        $lifetipTag = Param::getExactParamItem('lifetip', 'article');
        $lifetipList = News::with(['getThumbnail', 'getCategoryNews'])->where('tag', $lifetipTag->id)->whereDate('published_at', '<=', date('Y-m-d'))->select(DB::raw('*, TIMESTAMPDIFF(DAY, `published_at`, NOW()) as `datecount`'))->orderBy('published_at', 'DESC')->orderBy('created_at', 'DESC')->take(5)->get();

        // Business Category List
        // Inherit from Controller.php parent

        // LifetipCategoryList
        // Inherit from Controller.php

        // Personal Trading List
        $personalList = PersonalTrading::with(['category', 'type'])->select(DB::raw('*, TIMESTAMPDIFF(DAY, `updated_at`, NOW()) as `datecount`'))->orderBy('updated_at', 'DESC')->take(3)->get();
        // BullBoard List
        $bullboardList = BullBoard::with(['category'])->select(DB::raw('*, TIMESTAMPDIFF(DAY, `updated_at`, NOW()) as `datecount`'))->orderBy('updated_at', 'DESC')->take(3)->get();
        // RealEstate List
        $realEstateList = RealEstate::with(['category', 'type', 'price'])->select(DB::raw('*, TIMESTAMPDIFF(DAY, `updated_at`, NOW()) as `datecount`'))->orderBy('updated_at', 'DESC')->take(3)->get();
        // JobSearching List
        $jobSearchingList = JobSearching::with(['category', 'type'])->select(DB::raw('*, TIMESTAMPDIFF(DAY, `updated_at`, NOW()) as `datecount`'))->orderBy('updated_at', 'DESC')->take(3)->get();

        $this->data['newsList'] = $newsList;
        $this->data['newsRankingList'] = $newsRankingList;
        $this->data['promotionList'] = $promotionList;
        $this->data['promotionRankingList'] = $promotionRankingList;
        $this->data['lifetipList'] = $lifetipList;
        $this->data['personalList'] = $personalList;
        $this->data['bullboardList'] = $bullboardList;
        $this->data['realEstateList'] = $realEstateList;
        $this->data['jobSearchingList'] = $jobSearchingList;

        return view('www.pages.home.index')->with($this->data);
    }

    public function termOfUse() {
        return view('www.pages.common.term-of-use')->with($this->data);
    }

    public function construction() {
        return view('www.pages.common.constructor')->with($this->data);
    }

    public function getContact() {
        return view('www.pages.common.contact')->with($this->data);
    }

    public function postContact(Request $request) {
        $name = $request->name;
        $company = $request->company;
        $phone = $request->phone;
        $email = $request->email;
        $subject = $request->subject;
        $content = $request->content;


        Mail::to('info-myanmar@poste-vn.com')->send(new Contact($name, $company, $subject, $phone, $email, $content));

        return redirect('/');
    }

    public function getDistrictFromCity($city_id)
    {
        $districtList = District::getDistrictListFromCity($city_id);

        $html = '<option value="0">Please choose District</option>';

        foreach ($districtList as $district) {
            $html .= '<option value="' . $district->id . '">' . $district->name . '</option>';
        }

        return response()->json(['result' => 1, 'view' => $html]);
    }

    public function redirect(Request $request) {
        if(!isset($request->href)) {
            $this->data['pageTitle'] = 'Page Not Found | '.$this->pageTitle;
            return view('errors.404')->with($this->data);
        }

        $this->data['message']  = '';

        if(!isset($request->utm_campaign)) {
            $this->data['message'] .= '<br/>Missing utm_campaign';
        }

        if(!isset($request->utm_source)) {
            $this->data['message'] .= '<br/>Missing utm_source';
        }
        if(!isset($request->utm_medium)) {
            $this->data['message'] .= '<br/>Missing utm_medium';
        }

        $this->pageTitle = 'Redirect Page | '.$this->pageTitle;
        $this->data['href'] = $request->href;

        return view('www.pages.common.redirect')->with($this->data);
    }

    /**
    *
    *  Advertisement Page
    *
    */

    public function advertisement() {
        return view('www.pages.common.advertisement')->with($this->data);
    }
}
