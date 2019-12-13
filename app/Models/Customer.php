<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model {
    use SoftDeletes;

    protected $table = 'customers';

    protected $dates = ['deleted_at'];

    public $fillable = ['name', 'owner_name', 'phone', 'email', 'user_id'];

    // RelationShip
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getAds() {
        return $this->hasMany('App\Models\Ad', 'customer_id', 'id');
    }

    public function getNews() {
        return $this->hasMany('App\Models\News', 'customer_id', 'id');
    }

    // Static function
    public static function getCustomerList($getTrashed = false) {
        if($getTrashed) {
            return self::with('getUser')->withTrashed()->orderBy('id', 'desc')->get();
        } else {
            return self::orderBy('id', 'desc')->get();
        }
    }

    public static function getCustomerItem($id) {
        return self::withTrashed()->find($id);
    }

    public static function updateCustomer($data, $id) {
        $customer = self::find($id);

        if(is_null($customer)) {
            return self::create($data);
        }

        $customer->name = $data['name'];
        $customer->owner_name = $data['owner_name'];
        $customer->phone = $data['phone'];
        $customer->email = $data['email'];
        $customer->user_id = $data['user_id'];
        return $customer->save();
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
