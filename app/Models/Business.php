<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

protected $table = 'businesses';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name', 'slug', 'english_name', 'address', 'city_id', 'district_id', 'description', 'phone', 'repre_phone', 'email', 'thumb_id', 'representator',
        'founding_date', 'employee_number', 'outline', 'customer_object', 'partner', 'capital', 'note', 'map',
        'website', 'user_id', 'fee', 'start_date', 'end_date', 'end_free_date', 'status', 'public_address', 'public_email', 'public_phone', 'pdf_url',
        'route_guide', 'img_route_guide', 'owner_id'
    ];

    // Relationship
    public function getDistrict() {
        return $this->belongsTo('App\Models\District', 'district_id', 'id');
    }

    public function getCity() {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    public function getThumb() {
        return $this->belongsTo('App\Models\Gallery', 'thumb_id', 'id');
    }

    public function getCategories() {
        return $this->hasManyThrough('App\Models\Category', 'App\Models\CategoryBusiness', 'business_id', 'id', 'id', 'category_id');
    }

    public function getBusinessCategoryList() {
        return $this->hasMany('App\Models\CategoryBusiness', 'business_id', 'id');
    }

    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withTrashed();
    }

    public function getOwner() {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id')->withTrashed();
    }

    public function getBusinessGallery() {
        return $this->hasMany('App\Models\BusinessGallery', 'business_id', 'id');
    }

    public function getGalleries() {
        return $this->hasManyThrough('App\Models\Gallery', 'App\Models\BusinessGallery', 'business_id', 'id', 'id', 'gallery_id')->withTrashed();
    }

    public function getServiceList() {
        return $this->hasMany('App\Models\BusinessService', 'business_id', 'id');
    }

    public function getMapList() {
        return $this->hasMany('App\Models\BusinessMap', 'business_id', 'id');
    }

    public function getBusinessRelateList() {
        return $this->hasMany('App\Models\BusinessRelate', 'business_id', 'id');
    }

    public function getImageRouteGuide() {
        return $this->belongsTo('App\Models\Gallery', 'img_route_guide', 'id');
    }

    public static function changeStatus($id) {
        $ad = self::withTrashed()->find($id);

        if(is_null($ad)) {
            return response()->json(['result' => 0, 'error' => 'Don\'t find any ad']);
        }

        if($ad->trashed()) {
            $ad->restore();
            $status = 1;
        } else {
            $ad->delete();
            $status = 0;
        }

        return response()->json(['result' => 1, 'status' => $status]);
    }
}
