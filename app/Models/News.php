<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\CategoryNews;
use App\Models\ContentNews;
use App\Models\Gallery;
use App\Models\NewsImage;

class News extends Model {
    use SoftDeletes;

    const PROMOTION_CATEGORY_ID = 5;
    const EVENT_CATEGORY_ID = 6;

    protected $table = 'news';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name', 'slug', 'keywords', 'description', 'tag', 'category_id', 'thumb_id', 'city_id', 'start_date', 'end_date', 'related_ids', 'published_at', 'view', 'customer_id', 'user_id', 'author'
    ];

    /* Relationship */
    public function getTag() {
        return $this->belongsTo('App\Models\Param', 'tag', 'id');
    }

    public function getCategories() {
        return $this->belongsToMany('App\Models\Category', 'category_news', 'news_id', 'category_id');
    }

    public function getCity() {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    public function getThumbnail() {
        return $this->belongsTo('App\Models\Gallery', 'thumb_id', 'id')->withTrashed();
    }

    public function getCustomer() {
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }

    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getCategoryNews() {
        return $this->hasMany('App\Models\CategoryNews', 'news_id', 'id');
    }

    public function getContents() {
        return $this->hasMany('App\Models\ContentNews', 'news_id', 'id');
    }

    public function getCategoryIdList() {
        return $this->getCategoryNews->pluck('category_id')->toArray();
    }

    public function getImageArticleList() {
        return $this->hasManyThrough('App\Models\Gallery', 'App\Models\NewsImage', 'news_id', 'id', 'id', 'gallery_id');
    }

    public function GetNewsImages() {
        return $this->hasMany('App\Models\NewsImage', 'news_id', 'id');
    }

    /* Static function */
    public static function getListByTag($tag = 0, $getTrashed = false) {
        if($getTrashed) {
            return self::with('getUser')->withTrashed()->where('tag', $tag)->get();
        } else {
            return self::with('getUser')->where('tag', $tag)->get();
        }
    }

    public static function getItem($id, $getTrashed = false) {
        if($getTrashed) {
            return self::with(['getCategories', 'getContents'])->withTrashed()->find($id);
        } else {
            return self::with(['getCategories', 'getContents'])->find($id);
        }
    }

    public static function updateNews($data, $id, $categoryIds = [], $titles = [], $contents = [], $status = true) {
        $article = self::withTrashed()->find($id);

        if(is_null($article)) {
            $article = self::create($data);

            if($status) {
                if($article->trashed()) {
                    $article->restore();
                }
            } else {
                if(!$article->trashed()) {
                    $article->delete();
                }
            }

            if(!empty($categoryIds)) {
                CategoryNews::updateNewsCategory($article->id, $categoryIds);
            }

            if(!empty($contents)) {
                ContentNews::updateNewsContent($article->id, $titles, $contents);
            }
        } else {
            if($data['thumb_id'] != 0 && $data['thumb_id'] != $article->thumb_id) {
                Gallery::deleteFile($article->thumb_id, true);
                // $article->thumb_id = $data['thumb_id'];
            } else {
                unset($data['thumb_id']);
            }

            $article->update($data);

            // $article->save();

            if($status) {
                if($article->trashed()) {
                    $article->restore();
                }
            } else {
                if(!$article->trashed()) {
                    $article->delete();
                }
            }

            if(!empty($categoryIds)) {
                CategoryNews::updateNewsCategory($article->id, $categoryIds);
            }

            if(!empty($contents)) {
                ContentNews::updateNewsContent($article->id, $titles, $contents);
            }
        }

        return $article;
    }

    public static function updateStatus($id) {
        $item = self::withTrashed()->find($id);

        if(is_null($item)) {
            return response()->json(['result' => 0, 'error' => 'Don\'t find any item']);
        }

        if($item->trashed()) {
            $item->restore();
            $status = 1;
        } else {
            $item->delete();
            $status = 0;
        }

        return response()->json(['result' => 1, 'status' => $status]);
    }

    public static function deleteCompletely($id) {
        $article = self::withTrashed()->find($id);

        if(!is_null($article)) {
            $gallery = $article->getThumbnail;

            if(!is_null($gallery)) {
                Gallery::clearGallery($gallery->id, 'news', $article->id);
            }
            $galleryList = $article->getImageArticleList;

            foreach($galleryList as $gallery) {
                Gallery::clearGallery($gallery->id, 'news', $article->id);
            }


            NewsImage::deleteByNewsId($article->id);

            $result = $article->forceDelete();

            if($result) {
                return array('result' => 1);
            }

            return array('result' => 0, 'error' => 'Something is wrong');
        }
        return array('result' => 0, 'error' => 'Can not find any article');
    }
}
