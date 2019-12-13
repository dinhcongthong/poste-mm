<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AdPosition extends Model
{
    use SoftDeletes;
    
    protected $table="ad_positions";
    
    public $fillable = ['name', 'slug', 'how_to_show', 'description', 'version_show', 'user_id'];
    
    // Relationship
    public function getAdList() {
        return $this->hasMany('App\Models\Ad', 'position_id', 'id');
    }
    
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    
    // Static function
    
    public static function getPositionList() {
        return self::with('getUser')->withTrashed()->orderBy('id', 'desc')->get();
    }
    public static function getPositionListNonTrashed() {
        return self::with('getUser')->orderBy('id', 'desc')->get();
    }
    
    public static function getPositionItem($id) {
        return self::with('getUser')->find($id);
    }
    
    public static function updatePosition($data, $id = 0) {
        $position = self::find($id);
        if(is_null($position)) {
            return self::create($data);
        }

        $position->name = $data['name'];
        $position->slug = $data['slug'];
        $position->how_to_show = $data['how_to_show'];
        $position->description = $data['description'];
        $position->version_show = $data['version_show'];
        $position->user_id = Auth::user()->id;

        return $position->save();
    }

    public static function changeHowToShow($id, $howToShowId) {
        $position = self::find($id);

        if(is_null($position)) {
            return response()->json(['result' => 0, 'error' => 'Don\'t find any Ads Position']);
        }

        $position->how_to_show = $howToShowId;
        $position->save();

        return response()->json(['result' => 1]);
    }

    public static function changeVersionShow($id, $versionShowId) {
        $position = self::find($id);

        if(is_null($position)) {
            return response()->json(['result' => 0, 'error' => 'Don\'t find any Ads Position']);
        }

        $position->version_show = $versionShowId;
        $position->save();

        return response()->json(['result' => 1]);
    }

    public static function getAdListShow($id, $limit = 0) {
        $item = self::with('getAdList.getImage')->find($id);

        if(is_null($item)) {
            return [];
        }
        if($item->how_to_show == 0) {
            $ad_list = $item->getAdList->where('inform_sale', 1)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->shuffle()->take($limit);
        } else {
            $ad_list = $item->getAdList->where('inform_sale', 1)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->sortByDesc('id')->take($limit);
        }

        return $ad_list;
    }
}
