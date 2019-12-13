<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Movie;

class MovieShowtime extends Model
{
    protected $table = 'movie_showtimes';

    public $fillable = [
        'movie_id', 'position_id', 'show_date', 'show_hours', 'city_id'
    ];

    // Relationship
    public function getMovie() {
        return $this->belongsTo('App\Models\Movie', 'movie_id', 'id')->withTrashed();
    }

    public function getCity() {
        return $this->belongsTo('App\Models\City', 'city_id', 'id')->withTrashed();
    }

    public function getPositionTheater() {
        return $this->belongsTo('App\Models\Theater', 'position_id', 'id')->withTrashed();
    }

    /* Static function */

    public static function clearOutDateShowTime() {
        $showtimeList = self::where('show_date', '<', date('Y-m-d'))->get();

        foreach($showtimeList as $show) {
            $show->delete();
        }
    }

    public static function updateShowTime($id, $data) {
        $showtime = self::find($id);

        if(is_null($showtime)) {
            return self::create($data);
        }

        $showtime->movie_id = $data['movie_id'];
        $showtime->position_id = $data['position_id'];
        $showtime->show_date = $data['show_date'];
        $showtime->show_hours = $data['show_hours'];
        $showtime->city_id = $data['city_id'];

        $showtime->save();

        return $showtime;
    }

    public static function getShowTimeList($movieId, $cityId) {
        return self::where('movie_id', $movieId)->where('city_id', $cityId)->orderBy('show_date', 'DESC')->get();
    }

    public static function deleteShowtime($id) {
        $show = self::find($id);

        if(is_null($show)) {
            return response()->json(['result' => 0, 'error' => 'Can not find any Showtime']);
        }

        $show->delete();

        return response()->json(['result' => 1]);
    }
}
