<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PosteNotification extends Model {

    public const TYPE_SYS_NOTI = 0;
    public const TYPE_FEEDBACK = 1;

    protected $table="notifications";

    public $fillable = ['post_id', 'post_type','email', 'owner_id', 'name', 'company_name', 'content', 'type_id', 'status'];

    public function getPosteTown() {
        return $this->belongsTo('App\Models\PosteTown', 'post_id', 'id')->withTrashed();
    }

    public function getBusinesses() {
        return $this->belongsTo('App\Models\Business', 'post_id', 'id')->withTrashed();
    }

    public function getPersonalTrading() {
        return $this->belongsTo('App\Models\PersonalTrading', 'post_id', 'id')->withTrashed();
    }

    public function getBullboard() {
        return $this->belongsTo('App\Models\BullBoard', 'post_id', 'id')->withTrashed();
    }

    public function getJobSearching() {
        return $this->belongsTo('App\Models\JobSearching', 'post_id', 'id')->withTrashed();
    }

    public function getRealEstate() {
        return $this->belongsTo('App\Models\RealEstate', 'post_id', 'id')->withTrashed();
    }
    // public static function getNotiLis() {
    //     $noti_list = self::whereHas('getPosteTownList.getOwner', function($query) {
    //         $query->where('id', Auth::user()->id);
    //     })->where('post_type', 'town')->toSql();
    //     return $noti_list;
    // }

    public function getType() {
        $route = '';
        $edit_route = '';
        $type = null;
        if($this->post_type == 'town') {
            $route = 'get_town_detail_route';
            $edit_route = 'get_town_edit_route';
            $type = $this->getPosteTown;
        } elseif($this->post_type == 'business') {
            $route = 'get_business_detail_route';
            $edit_route = 'get_business_edit_route';
            $type = $this->getBusinesses;
        }   elseif($this->post_type == 'personaltrading') {
            $route = 'get_personal_trading_detail_route';
            $edit_route = 'get_personal_trading_edit_route';
            $type = $this->getPersonalTrading;
        }   elseif($this->post_type == 'bullboard') {
            $route = 'get_bullboard_detail_route';
            $edit_route = 'get_bullboard_edit_route';
            $type = $this->getBullboard;
        }   elseif($this->post_type == 'jobsearching') {
            $route = 'get_jobsearching_detail_route';
            $edit_route = 'get_job_searching_edit_route';
            $type = $this->getJobSearching;
        }   elseif($this->post_type == 'realestate') {
            $route = 'get_real_estate_detail_route';
            $edit_route = 'get_real_estate_edit_route';
            $type = $this->getRealEstate;
        }
        return [
            'route' => $route,
            'edit_route' => $edit_route,
            'type'  => $type
        ];
    }
}
