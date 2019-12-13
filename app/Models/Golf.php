<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

use App\Models\Param;

class Golf extends Model
{
    use SoftDeletes;
    
    protected $table = 'golfs';
    
    protected $dates = ['deleted_at'];
    
    public $fillable = ['name', 'slug', 'keywords', 'tag', 'thumb_id', 'description', 'address', 'district_id', 'city_id', 'map', 'phone', 'work_time', 'website', 'budget', 'yard', 'caddy', 'rental', 'cart', 'facility', 'shower', 'lesson', 'golf_station_number', 'user_id'];
    
    // Relationship
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withTrashed();
    }
    
    public function getThumbnail() {
        return $this->belongsTo('App\Models\Gallery', 'thumb_id', 'id')->withTrashed();
    }
    
    public function getImageGolfList() {
        return $this->hasManyThrough('App\Models\Gallery', 'App\Models\GolfImage', 'golf_id', 'id', 'id', 'gallery_id');
    }
    
    public function getDistrict() {
        return $this->belongsTo('App\Models\District', 'district_id', 'id');
    }
    
    public function getCity() {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }
    
    /* Static Function  */
    public static function getNewestDraftItem($tag, $userId) {
        return self::withTrashed()->where('tag', $tag)->where('is_draft', true)->where('user_id', $userId)->orderBy('id', 'desc')->first();
    }
    
    public static function getItem($id, $getTrashed = false) {
        if($getTrashed) {
            return self::with('getCity', 'getDistrict', 'getThumbnail', 'getImageGolfList')->withTrashed()->find($id);
        } else {
            return self::with('getCity', 'getDistrict', 'getThumbnail', 'getImageGolfList')->find($id);
        }
    }
    
    public static function getItemWithTag($id, $tag, $getTrashed = false) {
        if($getTrashed) {
            return self::withTrashed()->where('tag', $tag)->where('id', $id)->orderBy('id', 'desc')->first();
        } else {
            return self::where('tag', $tag)->where('id', $id)->orderBy('id', 'desc')->first();
        }
    }
    
    public static function updateGolfStation($id, $data) {
        $item = self::withTrashed()->find($id);
        
        if(is_null($item)) {
            $item = self::create($data);
            $item->delete();
            return $item;
        }
        
        $item->name = $data['name'];
        $item->slug = $data['slug'];
        $item->keywords = $data['keywords'];
        $item->tag = $data['tag'];
        if($data['thumb_id'] != 0 && $data['thumb_id'] != $item->thumb_id) {
            Gallery::clearGallery($item->thumb_id, 'golf', $item->id);
            $item->thumb_id = $data['thumb_id'];
        }
        $item->description = $data['description'];
        $item->address = $data['address'];
        $item->district_id = $data['district_id'];
        $item->city_id = $data['city_id'];
        $item->phone = $data['phone'];
        $item->work_time = $data['work_time'];
        $item->website = $data['website'];
        $item->budget = $data['budget'];
        $item->map = $data['map'];
        $item->yard = $data['yard'];
        $item->caddy = $data['caddy'];
        $item->rental = $data['rental'];
        $item->cart = $data['cart'];
        $item->facility = $data['facility'];
        $item->shower = $data['shower'];
        $item->lesson = $data['lesson'];
        if(isset($data['golf_station_number'])) {
            $item->golf_station_number = $data['golf_station_number'];
        } else {
            $item->golf_station_number = 0;
        }
        $item->user_id = $data['user_id'];
        $item->is_draft = $data['is_draft'];
        $item->save();
        
        return $item;
    }
    public static function getGolfStationList($getTrashed = false) {
        $tagItem = Param::getExactParamItem('golf', 'article');
        if(is_null($tagItem)) {
            $tagItem = Param::createNew(array(
                'news_type' => 'golf',
                'tag_type' => 'article',
                'user_id' => Auth::user()->id,
                'show_on_gallery' => false
            ));
        }
        $tag = $tagItem->id;
        
        if($getTrashed) {
            return self::with('getUser', 'getDistrict', 'getCity', 'getThumbnail')->withTrashed()->where('tag', $tag)->orderBy('id', 'desc')->get();
        } else {
            return self::with('getUser', 'getDistrict', 'getCity', 'getThumbnail')->where('tag', $tag)->orderBy('id', 'desc')->get();
        }
    }
    
    public static function deleteArticle($id) {
        $article = self::withTrashed()->find($id);
        
        if(!is_null($article)) {
            $gallery = $article->getThumbnail;
            
            if(!is_null($gallery)) {
                $result = Gallery::clearGallery($gallery->id, 'golf', $article->id);
                return $result;
            }
            
            $galleryList = $article->getImageGolfList;
            foreach($galleryList as $gallery) {
                $result  = Gallery::clearGallery($gallery->id, 'golf', $article->id);
                return $result;
            }
            
            GolfImage::deleteByGolfId($article->id);
            
            $result = $article->forceDelete();
            
            if($result) {
                return array('result' => 1);
            }
            
            return array('result' => 0, 'error' => 'Something is wrong');
        }
        return array('result' => 1, 'error' => 'Can not find any Article');
    }
    
    // Static Golf Shop
    public static function getGolfShopList($getTrashed = false) {
        $tagItem = Param::getExactParamItem('golf-shop', 'article');
        if(is_null($tagItem)) {
            $tagItem = Param::createNew(array(
                'news_type' => 'golf-shop',
                'tag_type' => 'article',
                'user_id' => Auth::user()->id,
                'show_on_gallery' => false
            ));
        }
        $tag = $tagItem->id;
        
        if($getTrashed) {
            return self::with('getUser', 'getDistrict', 'getCity', 'getThumbnail')->withTrashed()->where('tag', $tag)->orderBy('id', 'desc')->get();
        } else {
            return self::with('getUser', 'getDistrict', 'getCity', 'getThumbnail')->where('tag', $tag)->orderBy('id', 'desc')->get();
        }
    }
    
    public static function changeStatus($id) {
        $item = self::withTrashed()->find($id);
        
        if(is_null($item)) {
            return ['result' => 0, 'error' => 'Can not find any article'];
        }
        
        if($item->trashed()) {
            $item->restore();
            $status = 1;
        } else {
            $item->delete();
            $status = 0;
        }
        
        return ['result' => 1, 'status' => $status];
    }
}
