<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsImage extends Model
{
    protected $table = 'news_images';
    
    public $fillable = ['news_id', 'gallery_id'];
    
    /* Relationship */
    public function getNews() {
        return $this->belongsTo('App\Models\News', 'news_id', 'id');
    }

    public function getGallery() {
        return $this->belongsTo('App\Models\Gallery', 'gallery_id', 'id');
    }
    
    /* Static function */
    public static function addNew($data) {
        return self::create($data);
    }

    public static function getListByNewsId($newsId) {
        return self::with('getGallery')->where('news_id', $newsId)->get();
    }
    
    public static function getItem($newsId, $galleryId) {
        return self::where('news_id', $newsId)->where('gallery_id', $galleryId)->orderBy('id', 'desc')->first();
    }

    public static function deleteByNewsId($newsId) {
        $newsImageList = self::where('news_id', $newsId)->get();

        foreach($newsImageList as $item) {
            $item->delete();
        }

        return true;
    }
}
