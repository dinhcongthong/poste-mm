<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;

    protected $table = "districts";

    protected $dates = ['deleted_at'];

    public $fillable = ['name', 'city_id', 'user_id', 'slug'];

    /* Relationship */
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getCity() {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    /* Static function */
    public static function getDistrict($getTrashed = false) {
        if($getTrashed) {
            return self::withTrashed()->get();
        } else {
            return self::all();
        }
    }

    public static function getDistrictListFromCity($city_id, $getTrashed = false) {
        if($getTrashed) {
            return self::withTrashed()->where('city_id', $city_id)->get();
        } else {
            return self::where('city_id', $city_id)->get();
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
        $item = self::withTrashed()->find($id);

        if(is_null($item)) {
            return self::create($data);
        }

        $item->name = $data['name'];
        $item->slug = $data['slug'];
        $item->user_id = $data['user_id'];
        $item->city_id = $data['city_id'];

        return $item->save();
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
