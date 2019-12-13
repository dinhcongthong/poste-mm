<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Notifications\PasswordReset;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /* constants */
    const TYPE_ADMIN = 1;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'first_name', 'last_name', 'kata_first_name', 'kata_last_name', 'email', 'password', 'type_id', 'gender_id', 'birthday', 'residence_id', 'occupation_id', 'phone', 'secret_question_id', 'answer', 'is_news_letter'
    ];

    // Relationship
    public function getAds() {
        return $this->hasMany('App\Models\Ad', 'user_id', 'id');
    }

    public function getNews() {
        return $this->hasMany('App\Models\News', 'user_id', 'id');
    }

    public function getGender() {
        return $this->belongsTo('App\Models\Setting', 'gender_id', 'id');
    }

    public function getOccupation() {
        return $this->belongsTo('App\Models\Setting', 'occupation_id', 'id');
    }

    public function getPersonalTradings() {
        return $this->hasMany('App\Models\PersonalTrading', 'user_id', 'id');
    }

    public function getRealEstate () {
        return $this->hasMany('App\Models\RealEstate', 'user_id', 'id');
    }

    public function getJobSearching () {
        return $this->hasMany('App\Models\JobSearching', 'user_id', 'id');
    }

    public function getBullBoard () {
        return $this->hasMany('App\Models\BullBoard', 'user_id', 'id');
    }

    public function getTownPage () {
        return $this->hasMany('App\Models\PosteTown', 'owner_id', 'id');
    }

    public function getBusinessPage () {
        return $this->hasMany('App\Models\Business', 'owner_id', 'id');
    }


    /**
    * Send the password reset notification.
    *
    * @param  string  $token
    * @return void
    */
    public function sendPasswordResetNotification($token) {
        $this->notify(new PasswordReset($token));
    }

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getUserList() {
        return self::withTrashed()->orderBy('id', 'desc')->get();
    }

    public function getThumb() {
        return $this->belongsTo('App\Models\Gallery', 'thumb_id', 'id');
    }

    public static function ajaxUpdateNewsLetter($id) {
        $user = User::withTrashed()->find($id);

        if(!is_null($user)) {
            if($user->is_news_letter) {
                $user->is_news_letter = false;
            } else {
                $user->is_news_letter = true;
            }
            $user->save();

            return response()->json(['result' => 1]);
        } else {
            return response()->json(['result' => 0, 'error' => 'Can not find any user with selected id']);
        }
    }

    public static function ajaxUpdatePermission($id, $type_id) {
        $user = User::withTrashed()->find($id);

        if(!is_null($user)) {
            if($user->type_id != $type_id) {
                $user->type_id = $type_id;
                $user->save();

                return response()->json(['result' => 1]);
            }
            return response()->json(['result' => 0, 'error' => 'The same Permission']);
        } else {
            return response()->json(['result' => 0, 'error' => 'Can not find any user with selected id']);
        }
    }

    public static function ajaxChangeStatus($id) {
        $user = User::withTrashed()->find($id);

        if(!is_null($user)) {
            if($user->trashed()) {
                $user->restore();
                $status = 1;
            } else {
                $user->delete();
                $status = 0;
            }

            return response()->json(['result' => 1, 'status' => $status]);
        } else {
            return response()->json(['result' => 0, 'error' => 'Can not find any user with selected id']);
        }
    }
}
