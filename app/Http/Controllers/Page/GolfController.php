<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Golf;
use App\Models\Param;

class GolfController extends Controller
{
    public function index() {
        $golfList = Golf::getGolfStationList();
        $golfShopList = Golf::getGolfShopList();

        $this->data['golfList'] = $golfList;
        $this->data['golfShopList'] = $golfShopList;

        return view('www.pages.golf.index')->with($this->data);
    }

    public function detail($detail) {
        $key = strrpos($detail, '-');
        $slug = substr($detail, 0, $key);
        $id = substr($detail, $key + 1);

        $article = Golf::getItem($id);
        $tag = Param::getExactParamItem('golf', 'article');

        if(is_null($article) || $article->tag != $tag->id) {
            $this->data['pageTitle'] = 'Page Not Found';
            return view('errors.404')->with($this->data);
        }

        if($article->slug != $slug) {
            return redirect()->route('get_golf_detail_route', $article->slug.'-'.$article->id);
        }

        $this->data['article'] = $article;

        $this->loadPageInfoFromChild('golf', 0, $article);

        return view('www.pages.golf.detail')->with($this->data);
    }

    public function shopDetail($detail) {
        $key = strrpos($detail, '-');
        $slug = substr($detail, 0, $key);
        $id = substr($detail, $key + 1);

        $article = Golf::getItem($id);
        $tag = Param::getExactParamItem('golf-shop', 'article');

        if(is_null($article) || $article->tag != $tag->id) {
            $this->data['pageTitle'] = 'Page Not Found';
            return view('errors.404')->with($this->data);
        }

         if($article->slug != $slug) {
            return redirect()->route('get_golf_shop_detail_route', $article->slug.'-'.$article->id);
        }

        $this->data['article'] = $article;

        $this->loadPageInfoFromChild('golf', 0, $article);

        return view('www.pages.golf.detail')->with($this->data);
    }
}
