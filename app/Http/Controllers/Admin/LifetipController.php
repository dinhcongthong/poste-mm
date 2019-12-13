<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\NewsRequest;

use App\Models\News;
use App\Models\Category;
use App\Models\Customer;
use App\Models\City;
use App\Models\Param;
use App\Models\ImageFactory;
use App\Models\Base;
use App\Models\Gallery;

class LifetipController extends Controller
{
    public function index() {
        // $tag = Param::getExactParamList('lifetip', 'article');
        // if($tag->isEmpty()) {
        //     $tag = Param::createNew(array(
        //         'news_type' => 'lifetip',
        //         'tag_type' => 'article',
        //         'user_id' => Auth::user()->id,
        //         'show_on_gallery' => false
        //     ));
        // } else {
        //     $tag = $tag[0];
        // }
        // $tag = $tag->id;

        // $lifetipList = News::getListByTag($tag, $getTrashed = true);

        // $this->data['lifetipList'] = $lifetipList;

        return view('admin.pages.lifetip.index')->with($this->data);
    }

    public function loadDataTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'user',
            3 => 'updated-at',
            4 => 'status',
            5 => 'action'
        );

        $tag = Param::getExactParamList('lifetip', 'article');
        if($tag->isEmpty()) {
            $tag = Param::createNew(array(
                'news_type' => 'lifetip',
                'tag_type' => 'article',
                'user_id' => Auth::user()->id,
                'show_on_gallery' => false
            ));
        } else {
            $tag = $tag[0];
        }
        $tag = $tag->id;

        // $totalData = News::withTrashed()->getListByTag($tag, $getTrashed = true)->count();
        $totalData = News::withTrashed()->where('tag', $tag)->get()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {
            $lifetipList = News::with('getUser')->withTrashed()->where('tag', $tag)->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $lifetipList =  News::withTrashed()->with(['getUser'])->where('tag', $tag)
            ->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhereHas('getUser', function($query) use($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->offset($start)->limit($limit)
            ->orderBy($order, $dir)
            ->get();

            $totalFiltered = News::withTrashed()->with(['getUser'])->where('tag', $tag)
            ->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhereHas('getUser', function($query) use($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->count();
        }

        $data = array();

        if(!empty($lifetipList)) {
            foreach ($lifetipList as $item) {
                $html = $item->id;
                $nestedData['id']  = $html;
            
                $html = $item->name;
                $html .= '<a href="'.route('get_lifetip_preview_ad_route', $item->slug.'-'.$item->id).'" class="mx-1" target="_blank">
                    <i class="fas fa-eye text-primary"></i>
                </a>';
                $nestedData['name']  = $html;

                $html = getUserName($item->getUser);
                $nestedData['user']  = $html;

                $html = $item->updated_at;
                $nestedData['updated-at']  = $html;

                $html = '<a href="#" class="change-status" data-id="'.$item->id.'">';
                            if($item->trashed()) {
                $html .=        '<i class="fas fa-times-circle text-danger"></i>';
                            } else {
                $html .=        '<i class="fas fa-check-circle text-success"></i>';
                            }
                $html .= '</a>';
                $nestedData['status']  = $html;

                $html = '<a class="mx-1" href="'.route('get_lifetip_edit_ad_route', ['id' => $item->id]).'">
                            <i class="fas fa-edit text-primary"></i>
                        </a>
                        <a class="mx-1 btn-delete" href="#" data-id="'.$item->id.'">
                            <i class="fas fa-trash text-danger"></i>
                        </a>';
                $nestedData['action']  = $html;

                $data[] = $nestedData;
            }
        }
         $json_data = array(
            'draw'              => intval($request->draw),
            'recordsTotal'      => intval($totalData),
            'recordsFiltered'   => intval($totalFiltered),
            'data'              => $data
        );

        return response()->json($json_data);
    }

    public function getUpdate($id = 0) {
        $categoryList = Category::getCategoryListFromParam('lifetip', 'category');
        $customerList = Customer::getCustomerList();
        $cityList = City::getCityList();

        $article = News::getItem($id, $getTrashed = true, $getCategories = false);

        if(is_null($article)) {
            if($id != 0) {
                return redirect()->route('get_lifetip_add_ad_route');
            }

            $name = '';
            $slug = '';
            $keywords = '';
            $description = '';
            $categoryIds = [];
            $thumbURL = '';
            $cityId = 0;
            $relatedIds = '';
            $publishedDate = '';
            $author = '';
            $status = 1;
            $titles = ['', '', ''];
            $contents = ['', '', ''];
        } else {

            $name = $article->name;
            $slug = $article->slug;
            $keywords = $article->keywords;
            $description = $article->description;
            $categoryIds = $article->getCategoryIdList();
            $thumbURL = Base::getUploadURL($article->getThumbnail->name, $article->getThumbnail->dir);
            $cityId = $article->city_id;
            $publishedDate = date('m-d-Y', strtotime($article->published_at));
            $relatedIds = $article->related_ids;
            $author = $article->author;
            $status = !$article->trashed();

            $contentList = $article->getContents;
            foreach($contentList as $contentItem) {
                $titles[] = $contentItem->title;
                $contents[] = $contentItem->content;
            }

            for($i = count($contentList); $i < 3; $i++) {
                $titles[] = '';
                $contents[] = '';
            }
        }
        if(old('name')) {
            $name = old('name');
        }
        if(old('slug')) {
            $slug = old('slug');
        }
        if(old('keywords')) {
            $keywords = old('keywords');
        }
        if(old('category_ids')) {
            $categoryIds = old('category_ids');
        }
        if(old('city_id')) {
            $cityId = old('city_id');
        }
        if(old('thumb_url')) {
            $thumbURL = old('thumb_url');
        }
        if(old('description')) {
            $description = old('description');
        }
        if(old('title_content')) {
            $titles = old('title_content');
        }
        if(old('content')) {
            $contents = old('content');
        }
        if(old('author')) {
            $author = old('author');
        }
        if(old('published_at')) {
            $publishedDate = old('published_at');
        }
        if(old('related_ids')) {
            $relatedIds = old('related_ids');
        }
        if(old('status')) {
            $status = old('status');
        }

        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['slug'] = $slug;
        $this->data['keywords'] = $keywords;
        $this->data['categoryIds'] = $categoryIds;
        $this->data['cityId'] = $cityId;
        $this->data['thumbURL'] = $thumbURL;
        $this->data['description'] = $description;
        $this->data['relatedIds'] = $relatedIds;
        $this->data['publishedDate'] = $publishedDate;
        $this->data['author'] = $author;
        $this->data['status'] = $status;
        $this->data['titles'] = $titles;
        $this->data['contents'] = $contents;

        $this->data['categoryList'] = $categoryList;
        $this->data['customerList'] = $customerList;
        $this->data['cityList'] = $cityList;

        return view('admin.pages.lifetip.update')->with($this->data);
    }

    public function postUpdate(NewsRequest $request, $id = 0) {

        $slug = $request->slug;
        if(empty($slug)) {
            $slug = $request->name;
        }
        $slug = str_slug($slug, '-');

        $galleryId = 0;
        if($request->hasFile('image')) {
            $file = $request->image;

            if(!is_null($file)) {
               $gallery_id_arr = Gallery::uploadImage(array($file), 'news', 'image');
                $galleryId = $gallery_id_arr;
            }
        }

        $newsTag = Param::getExactParamList('lifetip', 'article');

        if($newsTag->isEmpty()) {
            $newsTag = Param::createNew(array(
                'news_type' => 'lifetip',
                'tag_type' => 'article',
                'user_id' => Auth::user()->id,
                'show_on_gallery' => false
            ));
        } else {
            $newsTag = $newsTag[0];
        }
        $newsTag = $newsTag->id;

        $publishedDate = date_create_from_format('m-d-Y', $request->published_at);

        $data = array(
            'name' => $request->name,
            'slug' => $slug,
            'keywords' => $request->keywords,
            'customer_id' => 0,
            'city_id' => $request->city_id,
            'description' => $request->description,
            'author' => $request->author,
            'start_date' => NULL,
            'end_date' => NULL,
            'published_at' => $publishedDate->format('Y-m-d'),
            'user_id' => Auth::user()->id,
            'tag' => $newsTag,
            'related_ids' => $request->related_ids,
            'thumb_id' => $galleryId
        );

        $categoryIds = $request->category_ids;
        $titles = $request->title_content;
        $contents = $request->content;
        $status = $request->status;

        $result = News::updateNews($data, $id, $categoryIds, $titles, $contents, $status);

        if($result) {
            return redirect()->route('get_lifetip_index_ad_route');
        }
    }
    public function changeStatus(Request $request) {
        $id = $request->id;
        return News::updateStatus($id);
    }

    public function postDelete(Request $request) {
        $id = $request->id;

        $result = News::deleteCompletely($id);

        if($result['result']) {
            $tag = Param::getExactParamItem('lifetip', 'article');

            $tag = $tag->id;

            $lifetipList = News::getListByTag($tag, $getTrashed = true);

            $view = view('admin.pages.lifetip.table')->with(['lifetipList' => $lifetipList])->render();

            return response()->json(['result' => 1, 'view' => $view]);
        }

        return response()->json($result);
    }

    public function getPreview($article) {
        // Category List inherit from Controller.php

        // Dailyinfo List inherit from Controller.php

        $detail = explode('-', $article);
        $articleId = end($detail);

        $paramItem = Param::getExactParamItem('lifetip', 'article');
        $tag = $paramItem->id ?? 0;

        $article = News::getItem($articleId, true);

        if(is_null($article) || $article->tag != $tag) {
            $this->data['pageTitle'] = 'Page Not Found';
            return view('errors.404')->with($this->data);
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
        $relatedtList = News::with('getThumbnail')->where('tag', $article->tag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('published_at', 'DESC')->take(8)->get();

        $this->data['article'] = $article;
        $this->data['categoryItem'] = $categoryItem;
        $this->data['contentOb'] = $contentOb;
        $this->data['rankingList'] = $rankingList;
        $this->data['newsestList'] = $newsestList;
        $this->data['relatedtList'] = $relatedtList;
        $this->data['paginate'] = $paginate;

        // For SEO - Facebook Share
        $this->data['pageTitle'] = $article->name;
        $this->data['pageType'] = 'article';
        $this->data['pageImage'] = Base::getUploadURL($article->getThumbnail->name, $article->getThumbnail->dir);
        $this->data['pageDescription'] = $article->description;

        return view('www.pages.lifetip.preview')->with($this->data);
    }
}
