<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\CategoryNews;
use App\Models\News;
use App\Models\Param;
use App\Models\Base;

class DailyinfoController extends Controller
{
    public function index() {
        $categoryList = $this->data['dailyinfoCategoryList'];

        $categoryItem = $categoryList->first();

        return redirect()->route('get_dailyinfo_category_route', ['category' => $categoryItem->slug.'-'.$categoryItem->id]);
    }

    public function category($category) {
        $key = strrpos($category, '-');
        $slug = substr($category, 0, $key);
        $categoryId = substr($category, $key + 1);

        // Category List
        $categoryList = $this->data['dailyinfoCategoryList'];

        if(!is_numeric($categoryId) || !in_array($categoryId, $categoryList->pluck('id')->toArray())) {
            $this->data['pageTitle'] = 'Page Not Found';
            return view('errors.404')->with($this->data);
        }

        $categoryItem = $categoryList->where('id', $categoryId)->first();

        if($categoryItem->slug != $slug) {
            return redirect()->route('get_dailyinfo_category_route', $categoryItem->slug.'-'.$categoryItem->id);
        }

        $paramItem = Param::getExactParamItem('dailyinfo', 'article');
        $tag = $paramItem->id ?? 0;
        $lifetipParam = Param::getExactParamItem('lifetip', 'article');
        $lifetipTag = $lifetipParam->id ?? 0;

        // Article list
        $articleList = News::with('getThumbnail')->whereHas('getCategoryNews', function($query) use($categoryId) {
            $query->where('category_id', $categoryId);
        })->where('tag', $tag)->whereDate('published_at', '<=', date('Y-m-d'));

        if($categoryId == News::PROMOTION_CATEGORY_ID || $categoryId == News::EVENT_CATEGORY_ID) {
            $rankingList = $this->getNewsRanking($tag, 0);
        } else {
            $rankingList = $this->getNewsRanking($tag);
        }


        $articleList = $articleList->orderBy('published_at', 'DESC')->orderBy('created_at', 'DESC')->paginate(18);
        // Lifetips Recommend
        $recommendList = News::with('getThumbnail')->where('tag', $lifetipTag)->whereDate('published_at', '<=', date('Y-m-d'))->inRandomOrder()->take(3)->get();

        // // Current Category
        // $categoryItem = Category::getItem($categoryId);


        $this->data['articleList'] = $articleList;
        $this->data['rankingList'] = $rankingList;
        $this->data['recommendList'] = $recommendList;
        $this->data['categoryItem'] = $categoryItem;

        $this->loadPageInfoFromChild('dailyinfo', $categoryId);

        return view('www.pages.dailyinfo.index')->with($this->data);
    }

    public function detail($detail) {
        $key = strrpos($detail, '-');
        $slug = substr($detail, 0, $key);
        $articleId = substr($detail, $key + 1);

        $paramItem = Param::getExactParamItem('dailyinfo', 'article');
        $tag = $paramItem->id ?? 0;

        $article = News::getItem($articleId);

        if(is_null($article) || $article->tag != $tag) {
            $this->data['pageTitle'] = 'Page Not Found';
            return view('errors.404')->with($this->data);
        }

        if($article->slug != $slug) {
            return redirect()->route('get_dailyinfo_detail_route', $article->slug.'-'.$article->id);
        }

        // Update View Number
        $request_ip = Request()->ip();
        $black_ip_list = env('BLACKLIST_IP');
        $black_ip_list = explode(',', $black_ip_list);
        $black_ip_list = array_map('trim', $black_ip_list);

        if(!in_array($request_ip, $black_ip_list)) {
            $article->view += 1;
            $article->timestamps = false;
            $article->save();
        }


        // Category List
        $categoryList = $this->data['dailyinfoCategoryList'];
        // LifetipCategory List inherit from Controller.php

        $page = $_GET['page'] ?? 0;

        if($page <= 1) {
            $page = 0;
        } else {
            $page -= 1;
        }

        $contents = $article->getContents;
        $contentOb = $contents[$page];

        // Variable to assign this article is promotion or event
        $checkPrEv = false;
        $articleCategoryIdList = $article->getCategories->pluck('id')->toArray();

        $paginate['totalPage'] = $contents->count();
        $paginate['currentPage'] = $page;
        $paginate['nextTitle'] = $page < ($paginate['totalPage'] - 1) ? $cotents[$page + 1]->title : '';
        $paginate['hrefPrex'] = $page > 0 ? route('get_dailyinfo_detail_route', $article->slug.'-'.$article->id).'?page='.($page - 1) : '';
        $paginate['nextPrex'] = $page > 0 ? route('get_dailyinfo_detail_route', $article->slug.'-'.$article->id).'?page='.($page - 1) : '';

        // Ranking List get from Parent Function

        if(in_array(News::PROMOTION_CATEGORY_ID, $articleCategoryIdList) || in_array(News::EVENT_CATEGORY_ID, $articleCategoryIdList)) {
            $checkPrEv = true;
            $categoryItem = $article->getCategories->filter(function($value, $key) {
                return ($value->id == News::PROMOTION_CATEGORY_ID || $value->id == News::EVENT_CATEGORY_ID);
            })->first();
            // Ranking List
            $rankingList = $this->getNewsRanking($article->tag, 0);
            // Recommend List
            $relatedtList = News::with('getThumbnail')->whereHas('getCategoryNews', function($query) {
                $query->where('category_id', News::PROMOTION_CATEGORY_ID)->orWhere('category_id', News::EVENT_CATEGORY_ID);
            })->where('tag', $article->tag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('published_at', 'DESC')->orderBy('created_at', 'DESC')->take(8)->get();
        } else {
            $categoryItem = $article->getCategories->first();
            // Ranking List
            $rankingList = $this->getNewsRanking($article->tag);
            // Recommend List
            $relatedtList = News::with('getThumbnail')->whereHas('getCategoryNews', function($query) {
                $query->where('category_id', '<>', News::PROMOTION_CATEGORY_ID)->where('category_id', '<>', News::EVENT_CATEGORY_ID);
            })->where('tag', $article->tag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('published_at', 'DESC')->orderBy('created_at', 'DESC')->take(8)->get();
        }

        // Newest List
        $lifetipParam = Param::getExactParamItem('lifetip', 'article');
        $lifetipTag = $lifetipParam->id ?? 0;
        $newsestList = News::with('getThumbnail')->where('tag', $lifetipTag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('updated_at', 'DESC')->take(5)->get();

        $this->data['article'] = $article;
        $this->data['categoryItem'] = $categoryItem;
        $this->data['contentOb'] = $contentOb;
        $this->data['rankingList'] = $rankingList;
        $this->data['newsestList'] = $newsestList;
        $this->data['relatedtList'] = $relatedtList;
        $this->data['paginate'] = $paginate;
        $this->data['checkPrEv'] = $checkPrEv;

        // Get Meta Info for SEO
        $this->loadPageInfoFromChild('dailyinfo', 0, $article);

        return view('www.pages.dailyinfo.detail')->with($this->data);
    }
}
