<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Models\PosteTown;
use App\Models\Business;
use App\Models\Ad;


class HomeController extends Controller
{
    public function index() {

        $date2WeekBefore = date('Y-m-d', strtotime('+14 days'));

        $ad_remain_list = Ad::with(['getAdPosition'])->whereDate('end_date', '>=', date('Y-m-d'))->whereDate('end_date', '<=', $date2WeekBefore)->get();

        $town_remain_list = PosteTown::whereDate('end_date', '>=', date('Y-m-d'))->whereDate('end_date', '<=', $date2WeekBefore)->get();

		$business_remain_list = Business::where('fee', 1)->whereDate('end_date', '>=', date('Y-m-d'))->whereDate('end_date', '<=', $date2WeekBefore)->get();

        $this->data['ad_remain_list'] = $ad_remain_list;
        $this->data['town_remain_list'] = $town_remain_list;
        $this->data['business_remain_list'] = $business_remain_list;

        return view('admin.pages.home.index')->with($this->data);
    }
}
