<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Gallery;

class Theater extends Model
{
    use SoftDeletes;
    
    protected $table = 'movie_theaters';
    
    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'name', 'address', 'description', 'thumb_id', 'parent_id', 'district_id', 'city_id', 'user_id'
    ];
    
    // Relationship
    public function getParentTheater() {
        return $this->belongsTo('App\Models\Theater', 'parent_id', 'id');
    }
    
    public function getChildTheater() {
        return $this->hasMany('App\Models\Theater', 'parent_id', 'id');
    }
    public function getChildTheaterWithTrashed() {
        return $this->hasMany('App\Models\Theater', 'parent_id', 'id')->withTrashed();
    }
    
    public function getDistrict() {
        return $this->belongsTo('App\Models\District', 'district_id', 'id')->withTrashed();
    }
    
    public function getCity() {
        return $this->belongsTo('App\Models\City', 'city_id', 'id')->withTrashed();
    }
    
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    
    public function getShowtimes() {
        return $this->hasMany('App\Models\MovieShowtime', 'position_id', 'id');
    }
    
    public function getThumbnail() {
        return $this->belongsTo('App\Models\Gallery', 'thumb_id', 'id')->withTrashed();
    }
    
    /* Static function */
    public static function getTheaterList($getTrashed = false) {
        if($getTrashed) {
            $theaterList = self::with(['getChildTheater', 'getDistrict', 'getCity'])->withTrashed()->where('parent_id', 0)->get();
        } else {
            $theaterList = self::with(['getChildTheater', 'getDistrict', 'getCity'])->where('parent_id', 0)->get();
        }
        
        return $theaterList;
    }
    
    public static function getPositionTheaterList($getTrashed = false) {
        if($getTrashed) {
            $positionList = self::with('getParentTheater')->withTrashed()->where('parent_id', '<>', 0)->get();
        } else {
            $positionList = self::with('getParentTheater')->where('parent_id', '<>', 0)->get();
        }
        
        return $positionList;
    }
    
    public static function getItem($id, $getTrashed = false, $getRelation = false) {
        if($getRelation) {
            if($getTrashed) {
                return self::with(['getChildTheater', 'getParentTheater', 'getDistrict', 'getCity'])->withTrashed()->find($id);
            } else {
                return self::with(['getChildTheater', 'getParentTheater', 'getDistrict', 'getCity'])->find($id);
            }
        } else {
            if($getTrashed) {
                return self::withTrashed()->find($id);
            } else {
                return self::find($id);
            }
        }
    }
    
    public static function getPositionFromCityAndBranch($branchId, $cityId) {
        $positionList = self::where('parent_id', $branchId)->where('city_id', $cityId)->get();
        
        return $positionList;
    }
    
    public static function updateNew($id, $data) {
        $article = self::getItem($id, $getTrashed = true);
        
        if(is_null($article)) {
            return self::create($data);
        }
        
        $article->name = $data['name'];
        $article->address = $data['address'];
        $article->district_id = $data['district_id'];
        $article->city_id = $data['city_id'];
        $article->parent_id = $data['parent_id'];
        $article->description = $data['description'];
        $article->thumb_id = $data['thumb_id'];
        $article->user_id = $data['user_id'];
        
        $article->save();
        
        return $article;
    }
    
    public static function deletePosition($id) {
        $article = self::getItem($id, $getTrashed = true);
        
        if(!is_null($article)) {
            $showtimeList = $article->getShowtimes;
            
            foreach($showtimeList as $showtime) {
                $showtime->delete();
            }
            
            $gallery = $article->getThumbnail;
            
            if(!is_null($gallery)) {
                Gallery::clearGallery($gallery->id, 'theater', $article->id);
            }
            
            $article->forceDelete();
            return array('result' => 1);
        }
        
        return [
            'result' => 0, 
            'error' => 'Can not find position theater'
        ];
    }
    
    public static function changeStatus($id) {
        $theater = self::withTrashed()->find($id);
        
        if(!is_null($theater) && $theater->parent_id != 0) {
            if($theater->trashed()) {
                $theater->restore();
                $status = 1;
            } else {
                $theater->delete();
                $status = 0;
            }
            
            return response()->json(['result' => 1, 'status' => $status]);
        }
        
        return response()->json(['result' => 0, 'error' => 'Can not find any position']);
    }
}
