<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $table = "cities";

    protected $dates = ['deleted_at'];

    public $fillable = ['name', 'user_id', 'slug'];

    // Relationship
    public function geAds() {
        return $this->hasMany('App\Models\Ad', 'city_id', 'id');
    }

    public function getDistricts() {
        return $this->hasMany('App\Models\District', 'city_id', 'id');
    }

    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getNews() {
        return $this->hasMany('App\Models\News', 'city_id', 'id');
    }

    public function getTowninfos() {
        return $this->hasMany('App\Models\Towninfo', 'city_id', 'id');
    }

    // static function
    public static function getCityList($getTrashed = false) {
        if($getTrashed) {
            return self::with('getUser')->withTrashed()->get();
        } else {
            return self::with('getUser')->get();
        }
    }

    public static function getItem($id, $getTrashed = false) {
        if($getTrashed) {
            return self::withTrashed()->find($id);
        } else {
            return self::find($id);
        }
    }

    public static function updateItem($data, $id) {
        $cityItem = self::withTrashed()->find($id);

        if(is_null($cityItem)) {
            return self::create($data);
        };

        $cityItem->name = $data['name'];
        $cityItem->slug = $data['slug'];
        $cityItem->user_id = $data['user_id'];

        return $cityItem->save();
    }
    public static function updateStatus($id) {
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
}
