<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\NewsImage;
use App\Models\Base;
use App\Models\Gallery;

class ContentNews extends Model
{
    protected $table = 'content_news';
    
    public $fillable = ['news_id', 'content', 'order_num'];
    
    // Static function
    public static function updateNewsContent($news_id, $titles, $contents) {
        $articleContents = self::where('news_id', $news_id)->orderBy('id', 'asc')->get();
        
        $srcAll = [];
        
        foreach($contents as $key => $content) {
            if(!empty($content)) {
                if(count($articleContents) > $key) {
                    $articleContentItem = $articleContents[$key];
                    $articleContentItem->title = $titles[$key];
                    $articleContentItem->content = $content;
                    $articleContentItem->save();
                } else {
                    self::create([
                        'news_id' => $news_id,
                        'title' => $titles[$key],
                        'content' => $content,
                        ]
                    );
                }
            } else {
                if(count($articleContents) > $key) {
                    if(!empty($articleContents[$key]->content)) {
                        $articleContentItem = $articleContents[$key];
                        $articleContentItem->delete();
                    }
                }
                break;
            }
            
            $srcList = [];
            
            $regex = '/<img.*?\s+src=(?:\'|\")([^\'\">]+)(?:\'|\")/';
            
            preg_match_all($regex, $content, $srcList);
            $srcList = $srcList[1];
            
            foreach($srcList as $src) {
                $srcAll[] = $src;
                $imgInfo = Base::getUploadFilename($src);
                $gallery = Gallery::getExactItem($imgInfo['filename'], $imgInfo['dir'], $getTrashed = true);
                
                if(!is_null($gallery)) {
                    $newsImg = NewsImage::getItem($news_id, $gallery->id);
                    
                    if(is_null($newsImg)) {
                        NewsImage::addNew([
                            'news_id' => $news_id,
                            'gallery_id' => $gallery->id
                            ]
                        );
                    }
                }
            }
        }
        $newsImageList = NewsImage::getListByNewsId($news_id);    
        foreach($newsImageList as $img) {
            $check = false;
            
            foreach($srcAll as $src) {
                $srcInfo = Base::getUploadFilename($src);
                if($srcInfo['filename'] == $img->getGallery->name && $srcInfo['dir'] == $img->getGallery->dir) {
                    $check = true;
                    break;
                }
            }
            
            if(!$check) {
                $newImgItem = NewsImage::find($img->id);
                $newImgItem->delete();
            }
        }    
    }
}
