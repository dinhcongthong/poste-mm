<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryNews extends Model
{
    protected $table = 'category_news';
    
    public $fillable = ['news_id', 'category_id'];
    
    // Static function 
    public static function getItem($newsId = 0, $categoryId = 0) {
        return self::where('news_id', $newsId)->where('category_id', $categoryId)->first();
    }
    
    public static function updateNewsCategory($newsId, $categoryIds = []) {
        $itemList = self::where('news_id', $newsId)->get();
        
        foreach($itemList as $item) {
            if(!in_array($item->category_id, $categoryIds)) {
                $item->delete();
            } else {
                if (($key = array_search($item->category_id, $categoryIds)) !== false) {
                    unset($categoryIds[$key]);
                }
            }
        }

        foreach($categoryIds as $categoryId) {
            self::create(array(
                'news_id' => $newsId,
                'category_id' => $categoryId
            ));
        }
    }
}
