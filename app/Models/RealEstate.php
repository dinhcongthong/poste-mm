<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\City;
use App\Models\Gallery;
use App\Models\User;
use App\Models\Param;

class RealEstate extends Model
{
    use SoftDeletes;

    const PARAM_BEDROOM_ID = 26;
    const PARAM_CATEGORY_ID = 27;
    const PARAM_PRICE_ID = 25;
    const PARAM_TYPE_ID = 24;

    protected $table = 'realestates';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'slug', 'name', 'type_id', 'category_id', 'price_id', 'content', 'city_id', 'first_image', 'second_image',
        'phone', 'email', 'show_phone_num', 'user_id', 'approver_id', 'bedroom_id', 'district_id', 'full_furniture',
        'internet', 'bathtub', 'pool', 'gym', 'electronic', 'television', 'kitchen', 'garage', 'security'
    ];
    /**
    * Relationship n - 1
    */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    /**
    * Relationship n - 1
    */
    public function type()
    {
        return $this->belongsTo('App\Models\Category', 'type_id', 'id');
    }

    /**
    * Relationship n - 1
    */
    public function district()
    {
        return $this->belongsTo('App\Models\District', 'district_id', 'id');
    }

    /**
    * Relationship n - 1
    */
    public function price()
    {
        return $this->belongsTo('App\Models\Category', 'price_id', 'id');
    }

    /**
    * Relationship n - 1
    */
    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    /**
    * Relationship n - 1
    */
    public function bedroom()
    {
        return $this->belongsTo('App\Models\Category', 'bedroom_id', 'id');
    }

    /**
    * Relationship n - 1
    */
    public function getFirstImage()
    {
        return $this->belongsTo('App\Models\Gallery', 'first_image', 'id');
    }

    /**
    * Relationship n - 1
    */
    public function getSecondImage()
    {
        return $this->belongsTo('App\Models\Gallery', 'second_image', 'id');
    }

    /**
    * Relationship n - 1
    */
    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
    * Relationship n - 1
    */

    public function approver()
    {
        return $this->belongsTo('App\Models\User', 'approver_id', 'id');
    }

    public static function getRealEstateList($getTrashed = false)
    {
        // var_dump($getTrashed);die;
        if($getTrashed) {
            return self::with('getUser')->withTrashed()->get();
        } else {
            return self::with('getUser')->get();
        }
    }

    public static function updateStatus($id)
    {
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

    public static function deleteItem($id)
    {
        $article = self::withTrashed()->find($id);

        if(!is_null($article)) {
            $gallery1 = $article->getFirstImage;
            $gallery2 = $article->getSecondImage;
            //dd($gallery1);
            if(!is_null($gallery1)) {
                Gallery::clearGallery($gallery1->id, 'realestate', $article->id);
            }
            if(!is_null($gallery2)) {
                Gallery::clearGallery($gallery2->id, 'realestate', $article->id);
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

    public static function updateItem($id, $data) {
        $article = self::withTrashed()->find($id);

        if(is_null($article)) {
            return self::create($data);
        }

        if(empty($data['pre_image1'])) {
            Gallery::clearGallery($article->first_image, 'realestate', $article->id);
        }

        if($data['first_image'] != $article->first_image && $data['first_image'] != 0) {
                if($article->first_image != 0) {
                    Gallery::clearGallery($article->first_image, 'realestate', $article->id);
                }
                $article->first_image = $data['first_image'];
        }

        if(empty($data['pre_image2'] )) {
            Gallery::clearGallery($article->second_image, 'realestate', $article->id);
        }

        if($data['second_image'] != $article->second_image && $data['second_image'] != 0) {
                if($article->second_image != 0 ) {
                    Gallery::clearGallery($article->second_image, 'realestate', $article->id);
                }
                $article->second_image = $data['second_image'];
        }

        $article->name = $data['name'];
        $article->slug = $data['slug'];
        $article->category_id = $data['category_id'];
        $article->type_id = $data['type_id'];
        $article->price_id = $data['price_id'];
        $article->bedroom_id = $data['bedroom_id'];
        $article->content = $data['content'];
        // $article->city_id = $data['city_id'];
        // $article->district_id = $data['district_id'];
        $article->phone = $data['phone'];
        $article->email = $data['email'];
        $article->show_phone_num = $data['show_phone_num'];
        $article->full_furniture = $data['full_furniture'];
        $article->internet = $data['internet'];
        $article->bathtub = $data['bathtub'];
        $article->gym = $data['gym'];
        $article->pool = $data['pool'];
        $article->electronic = $data['electronic'];
        $article->television = $data['television'];
        $article->kitchen = $data['kitchen'];
        $article->garage = $data['garage'];
        $article->security = $data['security'];

        $article->save();
        return $article;
    }

}
