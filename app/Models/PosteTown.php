<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class PosteTown extends Model
{
    use SoftDeletes;

    const STATUS_NORMAL = 1;
    const STATUS_TEMP_CLOSE = 2;
    const STATUS_OFFICIAL_CLOSE = 3;

    const SALE_INFORMING = 1;

    protected $table = 'poste_towns';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name', 'slug', 'avatar', 'description', 'city_id', 'address', 'route_guide', 'phone', 'map', 'email', 'website', 'facebook', 'user_id', 'customer_id', 'category_id', 'fee', 'start_date', 'end_date', 'credit',
        'working_time', 'regular_close', 'budget', 'private_room', 'smoking', 'currency', 'wifi', 'usage_scenes', 'service_tax',
        'check_in', 'check_out', 'laundry', 'breakfast', 'shuttle', 'air_condition', 'parking', 'kitchen', 'tv', 'shower', 'bathtub', 'luggage',
        'insurance', 'language', 'department',
        'target_student', 'object', 'tuition_fee', 'end_free_date', 'owner_id',
        'monday', 'tuesday', 'wednessday', 'thursday', 'friday', 'saturday', 'sunday'
    ];

    // Relationship
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withTrashed();
    }

    public function getOwner() {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id')->withTrashed();
    }

    public function getCity() {
        return $this->belongsTo('App\Models\Category', 'city_id', 'id');
    }

    public function getDistrict() {
        return $this->belongsTo('App\Models\District', 'district_id', 'id');
    }

    public function getCategory() {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function getThumbnail() {
        return $this->belongsTo('App\Models\Gallery', 'avatar', 'id');
    }

    public function getCustomer() {
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id')->withTrashed();
    }

    public function getRegularClose() {
        return $this->hasMany('App\Models\TownRegClose', 'town_id', 'id');
    }

    public function getTagList() {
        return $this->hasManyThrough('App\Models\Category', 'App\Models\TownTag', 'town_id', 'id', 'id', 'tag_id')->withTrashed();
    }

    public function getGalleryImages() {
        return $this->hasMany('App\Models\TownGallery', 'town_id', 'id');
    }

    public function getMenuList() {
        return $this->hasMany('App\Models\TownMenu', 'town_id', 'id');
    }

    public function getPDFFiles() {
        return $this->hasMany('App\Models\TownPDFMenu', 'town_id', 'id');
    }

    // Static

    public static function updateBasicInfo($id, $data) {
        $item = self::withTrashed()->find($id);

        if(is_null($item)) {
            if($id != 0) {
                return false;
            }
            return self::create($data);
        }

        if($item->user_id != $data['user_id'] && Auth::user()->type_id != User::TYPE_ADMIN) {
            return false;
        }

        if($item->avatar != 0) {
            if($data['avatar'] == 0) {
                unset($data['avatar']);
            } else {
                Gallery::clearGallery($item->avatar, 'poste-town', $item->id);
            }
        }

        if($item->owner_id != 0) {
            unset($data['owner_id']);
        }

        $result = $item->update($data);


        if($result) {
            return $item;
        }

        return false;
    }

    public static function updateFeatures($id, $data) {
        $item = self::withTrashed()->find($id);

        if(is_null($item)) {
            return false;
        }

        return $item->update($data);
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

    public static function updateWorkingTime($id, $data) {
        $town = PosteTown::find($id);

        if(is_null($town)) {
            return false;
        }

        $result = $town->update($data);

        if($result) {
            return true;
        }

        return false;
    }
}
