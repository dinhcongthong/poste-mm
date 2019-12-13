<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\BullBoard;
use App\Models\Business;
use App\Models\Golf;
use App\Models\JobSearching;
use App\Models\Movie;
use App\Models\News;
use App\Models\PersonalTrading;
use App\Models\PosteTown;
use App\Models\RealEstate;
use App\Models\Param;
use App\Models\Category;
use App\Models\Setting;

class SiteMapController extends Controller
{
    public function index() {
        // Category: businessCategoryList, lifetipCategoryList, posteTownCategoryList,
        // dailyinfoCategoryList inherited from Controller.php
        $tag = Param::getExactParamItem('dailyinfo', 'article');
        $item_list = News::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'slug', 'name', 'updated_at')->get();
        $this->data['dailyinfo_list'] = $item_list;

        // lifetipCategoryList inherited from Controller.php
        $tag = Param::getExactParamItem('lifetip', 'article');;
        $item_list = News::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'slug', 'name', 'updated_at')->get();
        $this->data['lifetips_list'] = $item_list;

        // Golf
        $tag = Param::getExactParamItem('golf', 'article');
        $item_list = Golf::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'slug', 'name', 'updated_at')->get();
        $this->data['golf_list'] = $item_list;

        // Golf Shop
        $tag = Param::getExactParamItem('golf-shop', 'article');
        $item_list = Golf::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'slug', 'name', 'updated_at')->get();
        $this->data['golf_shop_list'] = $item_list;

        // businessCategoryList inherited from Controller.php
        $item_list = Business::orderBy('updated_at', 'DESC')->select('id', 'slug', 'name', 'updated_at')->get();
        $this->data['business_list'] = $item_list;

        // posteTownCategoryList inherited from Controller.php
        $tag = Param::getExactParamItem('poste-town', 'sub-category');
        $tag_list = Category::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $item_list = PosteTown::orderBy('updated_at', 'DESC')->select('id', 'slug', 'name', 'updated_at')->get();
        $this->data['tag_list'] = $tag_list;
        $this->data['town_list'] = $item_list;

        // Cinema have 1 routes index

        // Personal Trading
        $tag = Param::getExactParamItem('personal-trading', 'category');
        $category_list = Category::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $tag = Param::getExactParamItem('personal-trading-type', 'setting');
        $type_list = Setting::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $item_list = PersonalTrading::orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $this->data['personal_category_list'] = $category_list;
        $this->data['personal_type_list'] = $type_list;
        $this->data['personal_list'] = $item_list;

        // RealEstate
        $tag = Param::getExactParamItem('realestate-form', 'category');
        $category_list = Category::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $tag = Param::getExactParamItem('realestate-type', 'category');
        $type_list = Category::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $tag = Param::getExactParamItem('realestate-price', 'category');
        $price_list = Category::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $tag = Param::getExactParamItem('realestate-bedroom', 'category');
        $bedroom_list = Category::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $item_list = RealEstate::orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $this->data['real_category_list'] = $category_list;
        $this->data['real_type_list'] = $type_list;
        $this->data['real_price_list'] = $price_list;
        $this->data['real_bedroom_list'] = $bedroom_list;
        $this->data['real_list'] = $item_list;

        // JobSearching
        $tag = Param::getExactParamItem('jobsearching-major', 'category');
        $category_list = Category::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $tag = Param::getExactParamItem('jobsearching-type', 'category');
        $type_list = Category::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $tag = Param::getExactParamItem('jobsearching-employee', 'category');
        $employee_list = Category::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $item_list = JobSearching::orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $this->data['job_category_list'] = $category_list;
        $this->data['job_type_list'] = $type_list;
        $this->data['job_employee_list'] = $employee_list;
        $this->data['job_list'] = $item_list;

        // Bullboard
        $tag = Param::getExactParamItem('bullboard', 'category');
        $category_list = Category::where('tag', $tag->id)->orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $item_list = BullBoard::orderBy('updated_at', 'DESC')->select('id', 'name', 'slug', 'updated_at')->get();
        $this->data['bullboard_category_list'] = $category_list;
        $this->data['bullboard_list'] = $item_list;

        // return $this->data;

        return response()->view('admin.pages.sitemap.index', $this->data)->header('Content-Type', 'text/xml');
    }
}
