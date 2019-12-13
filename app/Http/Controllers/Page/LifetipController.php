<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\CategoryNews;
use App\Models\News;
use App\Models\Param;
use App\Models\Base;

class LifetipController extends Controller
{
    public function index() {
        // lifetipCategoryList inherit from Controller.php
        $categoryList = $this->data['lifetipCategoryList'];

        $categoryItem = $categoryList->first();

        return redirect()->route('get_lifetip_category_route', ['category' => $categoryItem->slug.'-'.$categoryItem->id]);
    }

    public function category($category = 0) {
        $key = strrpos($category, '-');
        $slug = substr($category, 0, $key);
        $categoryId = substr($category, $key + 1);

        // Category List
        $categoryList = $this->data['lifetipCategoryList'];

        if(!is_numeric($categoryId) || !in_array($categoryId, $categoryList->pluck('id')->toArray())) {
            $this->data['pageTitle'] = 'Page Not Found';
            return view('errors.404')->with($this->data);
        }

        $categoryItem = $categoryList->where('id', $categoryId)->first();

        if($categoryItem->slug != $slug) {
            return redirect()->route('get_lifetip_category_route', $categoryItem->slug.'-'.$categoryItem->id);
        }

        $paramItem = Param::getExactParamItem('lifetip', 'article');
        $tag = $paramItem->id ?? 0;
        $recommendParam = Param::getExactParamItem('dailyinfo', 'article');
        $recommendTag = $recommendParam->id ?? 0;

        // Article list
        $articleList = News::with('getThumbnail')->where('tag', $tag)->whereHas('getCategoryNews', function($query) use($categoryId) {
            $query->where('category_id', $categoryId);
        })->where('tag', $tag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('published_at', 'DESC')->orderBy('created_at', 'DESC')->paginate(8);
        // Dailyinfo Recommend
        $recommendList = News::with('getThumbnail')->where('tag', $recommendTag)->whereYear('published_at', date('Y'))->whereDate('published_at', '<=', date('Y-m-d'))->whereHas('getCategoryNews', function($query) {
            $query->where('category_id', 5)->orWhere('category_id', 6);
        })->inRandomOrder()->take(3)->get();
        // Ranking List
        $rankingList = News::with('getThumbnail')->where('tag', $tag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('view', 'DESC')->take(5)->get();
        // Current Category
        $categoryItem = Category::getItem($categoryId);


        $this->data['articleList'] = $articleList;
        $this->data['rankingList'] = $rankingList;
        $this->data['recommendList'] = $recommendList;
        $this->data['categoryItem'] = $categoryItem;

        $this->loadPageInfoFromChild('lifetip', $categoryId);

        return view('www.pages.lifetip.index')->with($this->data);
    }

    public function detail($detail) {
        // Category List inherit from Controller.php

        // Dailyinfo List inherit from Controller.php

        $key = strrpos($detail, '-');
        $slug = substr($detail, 0, $key);
        $articleId = substr($detail, $key + 1);

        $paramItem = Param::getExactParamItem('lifetip', 'article');
        $tag = $paramItem->id ?? 0;

        $article = News::getItem($articleId);

        if(is_null($article) || $article->tag != $tag) {
            $this->data['pageTitle'] = 'Page Not Found';
            return view('errors.404')->with($this->data);
        }

        if($article->slug != $slug) {
            return redirect()->route('get_lifetip_detail_route', $article->slug.'-'.$article->id);
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


        $categoryItem = $article->getCategories->first();

        $page = $_GET['page'] ?? 0;

        $contents = $article->getContents;
        if($page <= 1) {
            $page = 0;
        } else {
            if($page > $contents->count()) {
                $url = route('get_lifetip_detail_route', $article->slug.'-'.$article->id).'?page='.$contents->count();
                return redirect($url);
            }
            $page -= 1;
        }
        $contentOb = $contents[$page];

        $paginate['totalPage'] = $contents->count();
        $paginate['currentPage'] = $page;
        $paginate['nextTitle'] = $page < ($paginate['totalPage'] - 1) ? $contents[$page + 1]->title : '';
        $paginate['hrefPrev'] = $page > 0 ? route('get_lifetip_detail_route', $article->slug.'-'.$article->id).'?page='.($page - 1) : '';
        $paginate['hrefNext'] = $page < ($paginate['totalPage'] - 1) ? route('get_lifetip_detail_route', $article->slug.'-'.$article->id).'?page='.($page + 2) : '';
        // Ranking List
        $rankingList = News::with('getThumbnail')->where('tag', $article->tag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('view', 'DESC')->take(5)->get();
        // Newest List
        $newsestList = News::with('getThumbnail')->where('tag', $article->tag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('updated_at', 'DESC')->take(5)->get();
        // Recommend List
        $relatedtList = News::with('getThumbnail')->where('tag', $article->tag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('published_at', 'DESC')->orderBy('created_at', 'DESC')->take(8)->get();

        $this->data['article'] = $article;
        $this->data['categoryItem'] = $categoryItem;
        $this->data['contentOb'] = $contentOb;
        $this->data['rankingList'] = $rankingList;
        $this->data['newsestList'] = $newsestList;
        $this->data['relatedtList'] = $relatedtList;
        $this->data['paginate'] = $paginate;

        // For SEO - Facebook Share
        $this->loadPageInfoFromChild('lifetip', 0, $article);

        return view('www.pages.lifetip.detail')->with($this->data);
    }
}
