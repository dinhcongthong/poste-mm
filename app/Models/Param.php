<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $table = 'params';
    
    public $fillable = ['news_type', 'tag_type', 'user_id', 'show_on_gallery'];
    
    /* Relationship */
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    
    public function getNews() {
        return $this->hasMany('App\Models\News', 'tag', 'id');
    }
    
    public function getCatgories() {
        return $this->hasMany('App\Models\Category', 'tag', 'id');
    }
    
    
    // Static function
    public static function getParamList() {
        return self::with('getUser')->orderBy('id', 'desc')->get();
    }
    
    public static function getExactParamList($news_type = '', $tag_type = '') {
        $paramList = self::orderBy('id', 'asc');
        
        if(!empty($news_type)) {
            $paramList = $paramList->where('news_type', $news_type);
        }
        
        if(!empty($tag_type)) {
            $paramList = $paramList->where('tag_type', $tag_type);
        }

        $paramList = $paramList->get();
        return $paramList;
    }
    
    public static function getParamItem($id = 0) {
        return Param::find($id);
    }
    
    public static function getExactParamItem($newsType, $tagType) {
        return Param::where('news_type', $newsType)->where('tag_type', $tagType)->first();
    }
    
    public static function changeShowOnGallery($id) {
        $param = self::find($id);
        
        if(!is_null($param)) {
            if($param->show_on_gallery) {
                $param->show_on_gallery = false;
                $status = false;
            } else {
                $param->show_on_gallery = true;
                $status = true;
            }
            $param->save();
            return response()->json(['result' => true, 'status' => $status]);
        } else {
            return response()->json(['result' => false, 'error' => 'No Param is found']);
        }
    }
    
    public static function getNewsTypeList() {
        return self::select('news_type')->distinct()->pluck('news_type');
    }
    
    public static function getTagTypeList() {
        return self::select('tag_type')->distinct()->pluck('tag_type');
    }
    
    public static function createNew($data) {
        $param = self::getExactParamItem(strtolower($data['news_type']), strtolower($data['tag_type']));
        if(is_null($param)) {
            return self::create($data);
        } else {
            return $param;
        }
    }
    
    public static function getIdListShowOnGallery() {
        return self::where('show_on_gallery', true)->pluck('id');
    }
    
    public static function getListShowOnGallery() {
        return self::where('show_on_gallery', true)->get();
    }
    
    public static function getCategoryParam() {
        return self::where('tag_type', 'category')->get();
    }
    
    public static function getSubCategoryParam() {
        return self::where('tag_type', 'sub-category')->get();
    }
}
