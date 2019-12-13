<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

use App\Models\Business;
use App\Models\PosteTown;
use Carbon\Carbon;

class SavedLink extends Model
{

    protected $table = 'saved_links';


    public $fillable = [
        'user_id', 'post_id', 'post_type'
    ];

    // Relationship
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withTrashed();
    }

    public function getThumbnail() {
        return $this->belongsTo('App\Models\Gallery', 'avatar', 'id');
    }

    public function getPosteTown() {
        return $this->belongsTo('App\Models\PosteTown', 'post_id', 'id')->withTrashed();
    }

    public function getBusiness() {
        return $this->belongsTo('App\Models\Business', 'post_id', 'id')->withTrashed();
    }


    // Static get post list
    public static function getPostList($user_id = 0, $post_type = '') {
        $post_list = [];

        switch ($post_type) {
            case 'town':
            $model = PosteTown;
            break;

            case 'business':
            $model = Business;
            break;

            default:
            $model = null;
            break;
        }

        if(!is_null($model)) {
            $save_item = self::where('user_id', $user_id)->where('post_type', $post_type)->first();

            if(!is_null($save_item)) {
                $post_id_arr = $save_item->post_id_arr;
                $post_id_arr = explode(',', $post_id_arr);

                foreach ($post_id_arr as $id) {
                    $post_list[] = $model::find($id);
                }
            }

        }

        return $post_list;
    }

    public static function timeAgo($time) {
        $out    = ''; // what we will print out
        // $now    = time(); // current time

        // $now    = date('Y-m-d H:i:s', strtotime(Carbon::now()) ); // current time

        $now = \Carbon\Carbon::createFromFormat( 'Y-m-d H:i:s', Carbon::now() );
        $_time = \Carbon\Carbon::createFromFormat( 'Y-m-d H:i:s', $time);
        // $day = \Carbon\Carbon::createFromFormat( 'Y-m-d', $time);
        // $diff = $now->diffInMinutes($_time);
        $diff = $now->diffInSeconds($_time);

        $one_minute = 60;
        $one_hour = 3600;
        $one_day = $one_hour * 24;
        $one_week = $one_day * 7;
        $one_month = $one_week * 4;
        $one_year = $one_month * 12;

        if(  $diff < 60 ) {
            return 'Now';
        } elseif($diff >= 60) {
            // ----
            if( $diff < $one_hour ) { // it happened X minutes ago
                return str_replace( '{num}', ( $out = round( $diff / 60 ) ), $out == 1 ? '{num} minute ago' : '{num} minutes ago' );
            } elseif($diff >= $one_hour) {
                if( $diff < $one_day ) { // it happened X hours ago
                    return str_replace( '{num}', ( $out = round( $diff / $one_hour ) ), $out == 1 ? '{num} hour ago' : '{num} hours ago' );
                } 
                elseif( $diff >= $one_day && $diff < $one_day * 2 ) { // it happened yesterday
                    return 'yesterday';

                } elseif($diff >= $one_day && $diff >= $one_day * 2) {
                    if( $diff < $one_week ) { 
                        return str_replace( '{num}', round( $diff / $one_day ) , '{num} days ago' );
                    } elseif($diff >= $one_week) {
                        if( $diff < $one_month) {
                            return str_replace( '{num}', ( $out = round( $diff / $one_week ) ), $out == 1 ? '{num} week ago' : '{num} weeks ago' );

                        } elseif($diff >= $one_month) {
                            return date('Y-m-d', strtotime($time) ) ;
                        }
                    }
                }
            }
        }

    }

}
