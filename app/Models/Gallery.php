<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Config;
use File;

use App\Models\Base;
use App\Models\ImageFactory;
use App\Models\Param;

class Gallery extends Model
{
    use SoftDeletes;

    protected $table = 'galleries';

    protected $dates = ['deleted_at'];

    public $fillable = ['name', 'dir', 'tag', 'user_id'];

    // RelationShip
    public function getUserAvatar() {
        return $this->hasMany('App\Models\User', 'thumb_id', 'id')->withTrashed();
    }

    public function getAds() {
        return $this->hasMany('App\Models\Ad', 'image', 'id')->withTrashed();
    }

    public function getNews() {
        return $this->hasMany('App\Models\News', 'thumb_id', 'id')->withTrashed();
    }

    public function getNewsByContent() {
        return $this->hasManyThrough('App\Models\News', 'App\Models\NewsImage', 'gallery_id', 'id', 'id', 'news_id')->withTrashed();
    }

    public function getGolfs() {
        return $this->hasMany('App\Models\Golf', 'thumb_id', 'id')->withTrashed();
    }

    public function getGolfByImage() {
        return $this->hasManyThrough('App\Models\Golf', 'App\Models\GolfImage', 'gallery_id', 'id', 'id', 'golf_id')->withTrashed();
    }

    public function getCategories() {
        return $this->hasMany('App\Models\Category', 'icon', 'id')->withTrashed();
    }

    public function getMovies() {
        return $this->hasMany('App\Models\Movie', 'image', 'id')->withTrashed();
    }

    public function getTheaters() {
        return $this->hasMany('App\Models\Theater', 'thumb_id', 'id')->withTrashed();
    }

    public function getPersonalFirstImage() {
        return $this->hasMany('App\Models\PersonalTrading', 'first_image', 'id')->withTrashed();
    }

    public function getPersonalSecondImage() {
        return $this->hasMany('App\Models\PersonalTrading', 'second_image', 'id')->withTrashed();
    }

    public function getBullboardFirstImage() {
        return $this->hasMany('App\Models\BullBoard', 'first_image', 'id')->withTrashed();
    }

    public function getBullboardSecondImage() {
        return $this->hasMany('App\Models\BullBoard', 'second_image', 'id')->withTrashed();
    }

    public function getRealEstateFirstImage() {
        return $this->hasMany('App\Models\RealEstate', 'first_image', 'id')->withTrashed();
    }

    public function getRealEstateSecondImage() {
        return $this->hasMany('App\Models\RealEstate', 'second_image', 'id')->withTrashed();
    }

    public function getPosteTowns() {
        return $this->hasMany('App\Models\PosteTown', 'avatar', 'id')->withTrashed();
    }

    public function getFoodImageTown() {
        return $this->hasMany('App\Models\TownMenuDetail', 'food_image', 'id');
    }

    public function getBusinessListFromAvatar() {
        return $this->hasMany('App\Models\Business', 'thumb_id', 'id')->withTrashed();
    }

    public function getBusinessListFromPrimaryMap() {
        return $this->hasMany('App\Models\Business', 'img_route_guide', 'id')->withTrashed();
    }

    public function getBusinessMapList() {
        return $this->hasMany('App\Models\BusinessMap', 'image_route_guide', 'id');
    }

    public function getBusinessGalleries() {
        return $this->hasMany('App\Models\BusinessGallery', 'gallery_id', 'id');
    }


    // Static function
    public static function getGalleryList($id = '', $name = '', $tag = '', $paginateSize = 0, $showGallery = true) {
        if($showGallery) {
            $galleryTags = Param::getIdListShowOnGallery();

            $galleryList = self::whereIn('tag', $galleryTags);
        } else {
            $galleryList = self::orderBy('id', 'asc');
        }

        if($id != '' && is_numeric($id)) {
            if(!empty($name)) {
                $galleryList->where('name', 'LIKE', '%'.$name.'%');
            } else {
                if(!empty($tag)) {
                    $galleryList = $galleryList->where('tag', $tag);
                } else {
                    return array($galleryList->find($id));
                }
            }
        } else {
            if(is_array($id)) {
                $galleryList->whereIn('id', $id);
            }
        }

        if(!empty($name)) {
            $galleryList = $galleryList->where('name', 'LIKE', '%'.$name.'%');
        }
        if(!empty($tag)) {
            $galleryList = $galleryList->where('tag', $tag);
        }

        if($paginateSize > 0) {
            return $galleryList->orderBy('id', 'desc')->paginate($paginateSize);
        } else {
            return $galleryList->orderBy('id', 'desc')->get();
        }
    }

    public static function getExactItem($filename = '', $dir = '', $getTrashed = false) {
        if($getTrashed) {
            $item = self::withTrashed();

        } else {
            $item = self::orderBy('id', 'asc');
        }

        if(!empty($filename)) {
            $item = $item->where('name', $filename);
        }

        if(!empty($dir)) {
            $item = $item->where('dir', $dir);
        }

        return $item->first();
    }

    public static function getItem($id, $getTrashed = false) {
        if($getTrashed) {
            return self::withTrashed()->find($id);
        } else {
            return self::find($id);
        }
    }

    public static function deleteFile($id, $remove_in_database = false) {
        $result = false;

        $path = Config::get('image.upload_path');
        $photo = self::withTrashed()->find($id);

        if(!is_null($photo)) {
            $path = rtrim($path, '/');
            $name = trim($photo->name, '/');
            $dir = trim($photo->dir, '/');

            $path = $path.'/'.$dir.'/'.$name;
            // Gallery exists
            if(File::exists($path)) {

                // File exists
                $result = File::delete($path);

                if(!$result) {
                    return $result;
                }
            }

            //delete in database
            if ($remove_in_database) {
                $result = $photo->forceDelete();
            }
        }

        return $result;
    }

    /**
     * Delete file by url of file
     *
     * @param string $url: URL of file want to delete
     *
     * @return boolean : result of deletion
     */
     public static function deleteFileByURL($url) {
        $fileInfo = Base::getUploadFilename($url);

        if(filter_var($fileInfo['filename'], FILTER_VALIDATE_URL)) {
            return true;
        }

        $path = Config::get('image.upload_path').'/'.$fileInfo['dir'].'/'.$fileInfo['filename'];

        // Gallery exists
        if(File::exists($path)) {

            // File exists
            $result = File::delete($path);

            if(!$result) {
                return $result;
            }
        }

        return false;
    }

    public static function addPhotoFromURL($url, $tag = 0) {
        $imgData = Base::getUploadFilename($url);

        $data = array(
            'name' => $imgData['filename'],
            'dir' => $imgData['dir'],
            'tag' => $tag,
            'user_id' => 0
        );

        $gallery = self::create($data);

        return $gallery ? $gallery->id : 0;
    }

    /**
    * Helper function to upload images
    *
    * @param array $files: images array want to upload
    * @param string $news_type: News Type of Image
    * @param string $tag_type: Tag type of image
    * @param string $dimension: Dimension you want to add.
    * @param boolean $create_param: Create new param when news_type and tag_type nonexists
    *
    * @return array|boolean return array of id (successfully) or false (Fail)
    */
    public static function uploadImage($image_files, $news_type = '', $tag_type = '', $dimension = '', $create_param = true) {
        $imgf = new ImageFactory();
        $file_url_arr = $imgf->upload($image_files, $news_type, $dimension);

        if(count($file_url_arr) == 0) {
            return false;
        }

        $tag = Param::getExactParamItem($news_type, $tag_type);
        if(is_null($tag)) {
            if($create_param) {
                $tag = Param::createNew(array(
                    'news_type' => $news_type,
                    'tag_type' => $tag_type,
                    'user_id' => Auth::user()->id,
                    'show_on_gallery' => false
                ));
            } else {
                 return false;
            }
        }
        $tag = $tag->id;

        $result = [];

        foreach($file_url_arr as $file_url) {
            $result[] = self::addPhotoFromURL($file_url, $tag);
        }

        return $result;

    }

    /**
    * Clear Gallery if don't afftect to User, News, Ad, Movie, Theater, Golf, Classify, Town, Business
    *
    * @param int    $id:            ID of gallery
    * @param string $articleType:   Type of article
    * @param int    $articleId:     ID of Article
    *
    * @return boolean true if delete it and don't effect, else false
    */

    public static function clearGallery($id, $articleType, $articleId) {
        // Please update this array when create new article type have using image
        $articleList = [
            'user',
            'news', 'ad', 'category', 'movie', 'theater', 'golf',
            'personal-trading', 'realestate', 'bullboard',
            'poste-town', 'town-food',
            'business-avatar', 'business-img-primary-map', 'business-img-map', 'business-gallery'
        ];

        if(!in_array($articleType, $articleList)) {
            return false;
        } else {
            $userId = 0;
            $newsId = 0; $towninfoId = 0; $adId = 0; $categoryId = 0; $movieId = 0;
            $theaterId = 0; $golfId = 0; $personalId = 0; $realEstateId = 0; $bullBoardId = 0;
            $townId = 0; $foodId = 0;
            $businessId = 0; $businessMapId = 0; $businessGalleryId = 0;

            switch($articleType) {
                case 'user':
                $userId = $articleId;
                break;

                case 'news':
                $newsId = $articleId;
                break;

                case 'ad':
                $adId = $articleId;
                break;

                case 'category':
                $categoryId = $articleId;
                break;

                case 'movie':
                $movieId = $articleId;
                break;

                case 'theater':
                $theaterId = $articleId;
                break;

                case 'golf':
                $golfId = $articleId;
                break;

                case 'personal-trading':
                $personalId = $articleId;
                break;

                case 'realestate':
                $realEstateId = $articleId;
                break;

                case 'bullboard':
                $bullBoardId = $articleId;
                break;

                case 'poste-town':
                $townId = $articleId;
                break;

                case 'town-food':
                $foodId = $articleId;
                break;

                case 'business-avatar':
                case 'business-img-primary-map':
                $businessId = $articleId;
                break;

                case 'business-img-map':
                $businessMapId = $articleId;
                break;

                case 'business-gallery':
                $businessGalleryId = $articleId;
                break;
            }

            $gallery = self::withTrashed()->find($id);
            if(!isset($gallery)) {
                return false;
            }

            $userList = $gallery->getUserAvatar->where('id', '<>', $userId);
            if(!$userList->isEmpty()) {
                return false;
            }

            $newsList = $gallery->getNews->where('id', '<>', $newsId);

            if(!$newsList->isEmpty()) {
                return false;
            }

            $newsList = $gallery->getNewsByContent->where('id', '<>', $newsId);

            if(!$newsList->isEmpty()) {
                return false;
            }

            $adList = $gallery->getAds->where('id', '<>', $adId);

            if(!$adList->isEmpty()) {
                return false;
            }

            $categoryList = $gallery->getCategories->where('id', '<>', $categoryId);

            if(!$categoryList->isEmpty()) {
                return false;
            }

            $movieList = $gallery->getMovies->where('id', '<>', $movieId);

            if(!$movieList->isEmpty()) {
                return false;
            }

            $theaterList = $gallery->getTheaters->where('id', '<>', $theaterId);

            if(!$theaterList->isEmpty()) {
                return false;
            }

            $golfList = $gallery->getGolfs->where('id', '<>', $golfId);
            if(!$golfList->isEmpty()) {
                return false;
            }

            $golfList = $gallery->getGolfByImage->where('id', '<>', $golfId);
            if(!$golfList->isEmpty()) {
                return false;
            }

            $personalTradingList = $gallery->getPersonalFirstImage->where('id', '<>', $personalId);
            if(!$personalTradingList->isEmpty()) {
                return false;
            }

            $personalTradingList = $gallery->getPersonalSecondImage->where('id', '<>', $personalId);
            if(!$personalTradingList->isEmpty()) {
                return false;
            }

            $bullBoardList = $gallery->getBullboardFirstImage->where('id', '<>', $bullBoardId);
            if(!$bullBoardList->isEmpty()) {
                return false;
            }

            $bullBoardList = $gallery->getBullboardSecondImage->where('id', '<>', $bullBoardId);
            if(!$bullBoardList->isEmpty()) {
                return false;
            }

            $realEstateList = $gallery->getRealEstateFirstImage->where('id', '<>', $realEstateId);
            if(!$realEstateList->isEmpty()) {
                return false;
            }

            $realEstateList = $gallery->getRealEstateSecondImage->where('id', '<>', $realEstateId);
            if(!$realEstateList->isEmpty()) {
                return false;
            }

            $townList = $gallery->getPosteTowns->where('id', '<>', $townId);
            if(!$townList->isEmpty()) {
                return false;
            }

            $foodList = $gallery->getFoodImageTown->where('id', '<>', $foodId);
            if(!$foodList->isEmpty()) {
                return false;
            }

            $businessList = $gallery->getBusinessListFromAvatar->where('id', '<>', $businessId);
            if(!$businessList->isEmpty()) {
                return false;
            }

            $businessList = $gallery->getBusinessListFromPrimaryMap->where('id', '<>', $businessId);
            if(!$businessList->isEmpty()) {
                return false;
            }

            $businessMapList = $gallery->getBusinessMapList->where('id', '<>', $businessMapId);
            if(!$businessMapList->isEmpty()) {
                return false;
            }

            $businessGalleryList = $gallery->getBusinessGalleries->where('id', '<>', $businessGalleryId);
            if(!$businessGalleryList->isEmpty()) {
                return false;
            }

            $result = self::deleteFile($gallery->id, true);
            return $result;
        }
    }
}
