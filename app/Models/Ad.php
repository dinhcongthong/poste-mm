<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Ad extends Model {
    use SoftDeletes;

    protected $table = 'ads';

    protected $dates = ['deleted_at'];

    public $fillable = ['name', 'position_id', 'customer_id', 'utm_campaign', 'image', 'description', 'link', 'city_id', 'user_id', 'start_date', 'end_date', 'note', 'inform_sale'];

    // Relationships
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getImage() {
        return $this->belongsTo('App\Models\Gallery', 'image', 'id');
    }

    public function getAdPosition() {
        return $this->belongsTo('App\Models\AdPosition', 'position_id', 'id');
    }

    public function getCustomer() {
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }

    public function getCity() {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    // Static function
    public static function getAdList() {
        return self::withTrashed()->orderBy('id', 'desc')->get();
    }

    public static function getItem($id) {
        return self::withTrashed()->find($id);
    }

    public static function updateAd($data, $id) {
        $ad = self::withTrashed()->find($id);

        if(is_null($ad)) {
            $ad = self::create($data);
            if(!$data['status']) {
                $ad->delete();
            }

            return $ad;
        }

        if(!$data['status']) {
            if(!$ad->trashed()) {
                $ad->delete();
            }
        } else {
            if($ad->trashed()) {
                $ad->restore();
            }
        }

        $ad->name = $data['name'];
        $ad->description = $data['description'];
        $ad->customer_id = $data['customer_id'];
        $ad->position_id = $data['position_id'];

        if($data['image'] != 0 && $ad->image != $data['image']) {
            Gallery::deleteFile($ad->image, true);
            $ad->image = $data['image'];
        }
        $ad->link = $data['link'];
        $ad->end_date = $data['end_date'];
        $ad->note = $data['note'];
        $ad->utm_campaign = $data['utm_campaign'];
        $ad->user_id = $data['user_id'];
        $ad->city_id = $data['city_id'];

        if($ad->end_date < date('Y-m-d')) {
            $ad->inform_sale = false;

            // Will config mail sent to cuustomer
        } else {
            $ad->inform_sale = true;
        }

        return $ad->save();
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

    public static function updateInform($id) {
        $ad = self::withTrashed()->find($id);

        if(is_null($ad)) {
            return response()->json(['result' => 0, 'error' => 'Don\'t find any ad']);
        }

        if($ad->inform_sale) {
            $ad->inform_sale = false;
            $mesStatus = '0';
        } else {
            $ad->inform_sale = true;
            $mesStatus = '1';
        }

        $user_id = Auth::user()->id;

        $ad->note .= "<br/> - User ID ". $user_id ." updated to ". $mesStatus ." in: ".date('Y-m-d H:i:s');
        $ad->save();

        $status = $ad->inform_sale;

        return response()->json(['result' => 1, 'status' => $status]);
    }

    public static function deleteAd($id) {
        $ad = self::withTrashed()->find($id);

        if(!is_null($ad)) {
            $image = $ad->getImage;

            if(!is_null($image)) {
                Gallery::clearGallery($image->id, 'ad', $id);
            }

            $result = $ad->forceDelete();

            if($result) {
                return [
                    'result' => 1
                ];
            }

            return [
                'result' => 0,
                'error' => 'Something is wrong'
            ];
        }

        return [
            'result' => 0,
            'error' => 'Can not find any ad'
        ];
    }
}
