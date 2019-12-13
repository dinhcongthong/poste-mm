<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Http\Requests\NewsRequest;

use App\Models\News;
use App\Models\Category;
use App\Models\Customer;
use App\Models\City;
use App\Models\Param;
use App\Models\ImageFactory;
use App\Models\Base;
use App\Models\Gallery;

class DailyinfoController extends Controller {
    public function index() {
        // $tag = Param::getExactParamList('dailyinfo', 'article');

        // if($tag->isEmpty()) {
        //     $tag = Param::createNew(array(
        //         'news_type' => 'dailyinfo',
        //         'tag_type' => 'article',
        //         'user_id' => Auth::user()->id,
        //         'show_on_gallery' => false
        //     ));
        // } else {
        //     $tag = $tag[0];
        // }
        // $tag = $tag->id;

        // $dailyinfoList = News::getListByTag($tag, $getTrashed = true);

        // $this->data['dailyinfoList'] = $dailyinfoList;

        return view('admin.pages.dailyinfo.index')->with($this->data);
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

        $tag = Param::getExactParamList('dailyinfo', 'article');

        if($tag->isEmpty()) {
            $tag = Param::createNew(array(
                'news_type' => 'dailyinfo',
                'tag_type' => 'article',
                'user_id' => Auth::user()->id,
                'show_on_gallery' => false
            ));
        } else {
            $tag = $tag[0];
        }
        $tag = $tag->id;

        $totalData = News::withTrashed()->where('tag', $tag)->get()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {
            $dailyinfoList = News::withTrashed()->with(['getUser'])->where('tag', $tag)->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $dailyinfoList =  News::withTrashed()->with(['getUser'])->where('tag', $tag)
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

        if(!empty($dailyinfoList)) {
            foreach ($dailyinfoList as $item) {
                $html =     $item->id;
                $nestedData['id']  = $html;

                $html =     $item->name;
                $html .=        '<a href="'.route('get_dailyinfo_preview_ad_route', $item->slug.'-'.$item->id).'" class="mx-1" target="_blank">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>';
                $nestedData['name']  = $html;

                $html =    getUserName($item->getUser);
                $nestedData['user']  = $html;

                $html =   $item->updated_at;
                $nestedData['updated-at']  = $html;

                $html =         '<a href="#" class="change-status" data-id="'.$item->id.'">';
                                    if($item->trashed()) {
                $html .=                '<i class="fas fa-times-circle text-danger"></i>';
                                    } else {
                $html .=                '<i class="fas fa-check-circle text-success"></i>';
                                    }
                $html .=        '</a>';
                $nestedData['status']  = $html;


                $html =        '<a class="mx-1" href="'.route('get_dailyinfo_edit_ad_route', ['id' => $item->id]).'">
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
        $categoryList = Category::getCategoryListFromParam('dailyinfo', 'category');
        $customerList = Customer::getCustomerList();
        $cityList = City::getCityList();

        $article = News::getItem($id, $getTrashed = true);

        if(is_null($article)) {
            if($id != 0) {
                return redirect()->route('get_dailyinfo_add_ad_route');
            }

            $name = '';
            $slug = '';
            $keywords = '';
            $description = '';
            $categoryIds = [];
            $thumbURL = '';
            $cityId = 0;
            $startDate = '';
            $endDate = '';
            $relatedIds = '';
            $publishedDate = '';
            $customerId = 0;
            $author = '';
            $status = 1;
            $titles = ['', '', ''];
            $contents = ['', '', ''];

            $tagItem = Param::getExactParamItem('dailyinfo', 'article');
            if(is_null($tagItem)) {
                $tagItem = Param::createNew(array(
                    'news_type' => 'dailyinfo',
                    'tag_type' => 'article',
                    'user_id' => Auth::user()->id,
                    'show_on_gallery' => false
                ));
            }
            $tag = $tagItem->id;
        } else {

            $name = $article->name;
            $slug = $article->slug;
            $keywords = $article->keywords;
            $description = $article->description;
            $categoryIds = $article->getCategoryIdList();
            $thumbnail = $article->getThumbnail;
            $thumbURL = $thumbnail ? Base::getUploadURL($thumbnail->name, $thumbnail->dir) : '';
            $cityId = $article->city_id;
            if(!is_null($article->start_date)) {
                $startDate = date('m-d-Y', strtotime($article->start_date));
            } else {
                $startDate = '';
            }
            if(!is_null($article->end_date)) {
                $endDate = date('m-d-Y', strtotime($article->end_date));
            } else {
                $endDate = '';
            }
            $relatedIds = $article->related_ids;
            $publishedDate = date('m-d-Y', strtotime($article->published_at));
            $customerId = $article->customer_id;
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
        if(old('customer_id')) {
            $customerId = old('customer_id');
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
        if(old('start_date')) {
            $startDate = old('start_date');
        }
        if(old('end_date')) {
            $endDate = old('end_date');
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
        $this->data['customerId'] = $customerId;
        $this->data['categoryIds'] = $categoryIds;
        $this->data['cityId'] = $cityId;
        $this->data['thumbURL'] = $thumbURL;
        $this->data['description'] = $description;
        $this->data['startDate'] = $startDate;
        $this->data['endDate'] = $endDate;
        $this->data['relatedIds'] = $relatedIds;
        $this->data['publishedDate'] = $publishedDate;
        $this->data['author'] = $author;
        $this->data['status'] = $status;
        $this->data['titles'] = $titles;
        $this->data['contents'] = $contents;

        $this->data['categoryList'] = $categoryList;
        $this->data['customerList'] = $customerList;
        $this->data['cityList'] = $cityList;

        return view('admin.pages.dailyinfo.update')->with($this->data);
    }

    public function postUpdate(NewsRequest $request, $id = 0) {
        if(in_array(News::PROMOTION_CATEGORY_ID, $request->category_ids) || in_array(News::EVENT_CATEGORY_ID, $request->category_ids)) {
            $errors = [];
            if(empty($request->start_date)) {
                $errors['start_date'] = 'Please choose Start Date';
            }
            if(empty($request->end_date)) {
                $errors['end_date'] = 'Please choose End Date';
            }

            if(!empty($errors)) {
                return back()->withErrors($errors);
            } else {
                $startDate = date_create_from_format('m-d-Y', $request->start_date)->format('Y-m-d');
                $endDate = date_create_from_format('m-d-Y', $request->end_date)->format('Y-m-d');
            }
        } else {
            $startDate = null;
            $endDate = null;
        }

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
                $galleryId = $gallery_id_arr[0];
            }
        }

        $newsTag = Param::getExactParamList('dailyinfo', 'article');

        if($newsTag->isEmpty()) {
            $newsTag = Param::createNew(array(
                'news_type' => 'dailyinfo',
                'tag_type' => 'article',
                'user_id' => Auth::user()->id,
                'show_on_gallery' => false
            ));
        } else {
            $newsTag = $newsTag[0];
        }
        $newsTag = $newsTag->id;



        $publishedDate = date_create_from_format('m-d-Y', $request->published_at)->format('Y-m-d');

        $data = array(
            'name' => $request->name,
            'slug' => $slug,
            'keywords' => $request->keywords,
            'customer_id' => $request->customer_id,
            'city_id' => $request->city_id,
            'description' => $request->description,
            'author' => $request->author,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'published_at' => $publishedDate,
            'user_id' => Auth::user()->id,
            'tag' => $newsTag,
            'related_ids' => $request->related_ids,
            'thumb_id' => $galleryId
        );

        $categoryIds = $request->category_ids;
        $contents = $request->content;
        $titles = $request->title_content;
        $status = $request->status;

        $result = News::updateNews($data, $id, $categoryIds, $titles, $contents, $status);

        if($result) {
            return redirect()->route('get_dailyinfo_index_ad_route');
        }
    }

    public function updateStatus(Request $request) {
        $id = $request->id;

        $result = News::updateStatus($id);
        return $result;
    }

    public function postDelete(Request $request) {
        $id = $request->id;

        $result = News::deleteCompletely($id);

        if($result['result']) {
            $tag = Param::getExactParamItem('dailyinfo', 'article');

            $tag = $tag->id;

            $dailyinfoList = News::getListByTag($tag, $getTrashed = true);

            $view = view('admin.pages.dailyinfo.table')->with(['dailyinfoList' => $dailyinfoList])->render();

            return response()->json(['result' => 1, 'view' => $view]);
        }

        return response()->json($result);
    }

    public function getPreview($article) {
        $detail = explode('-', $article);
        $articleId = end($detail);

        $paramItem = Param::getExactParamItem('dailyinfo', 'article');
        $tag = $paramItem->id ?? 0;

        $article = News::getItem($articleId, $getTrashed = true);

        if(is_null($article) || $article->tag != $tag) {
            $this->data['pageTitle'] = 'Page Not Found';
            return view('errors.404')->with($this->data);
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

        if(in_array(5, $articleCategoryIdList) || in_array(6, $articleCategoryIdList)) {
            $checkPrEv = true;
            $categoryItem = $article->getCategories->filter(function($value, $key) {
                return ($value->id == 5 || $value->id == 6);
            })->first();
            // Ranking List
            $rankingList = News::with('getThumbnail')->whereHas('getCategoryNews', function($query) {
                $query->orWhere('category_id', 5)->orWhere('category_id', 6);
            })->where('tag', $article->tag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('view', 'DESC')->take(5)->get();
            // Recommend List
            $relatedtList = News::with('getThumbnail')->whereHas('getCategoryNews', function($query) {
                $query->orWhere('category_id', 5)->orWhere('category_id', 6);
            })->where('tag', $article->tag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('published_at', 'DESC')->take(8)->get();
        } else {
            $categoryItem = $article->getCategories->first();
            // Ranking List
            $categoryRankingIdList = $categoryList->where('id', '<>', 5)->where('id', '<>', 6)->pluck('id')->toArray();
            $rankingList = News::with('getThumbnail')->whereHas('getCategoryNews', function($query) use($categoryRankingIdList) {
                $query->whereIn('category_id', $categoryRankingIdList);
            })->where('tag', $article->tag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('view', 'DESC')->take(5)->get();
            // Recommend List
            $relatedtList = News::with('getThumbnail')->whereHas('getCategoryNews', function($query) use($categoryRankingIdList){
                $query->whereIn('category_id', $categoryRankingIdList);
            })->where('tag', $article->tag)->whereDate('published_at', '<=', date('Y-m-d'))->orderBy('published_at', 'DESC')->take(8)->get();
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

        return view('www.pages.dailyinfo.preview')->with($this->data);
    }

}
