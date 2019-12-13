<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Gallery;

class Movie extends Model
{
    use SoftDeletes;
    
    protected $table = 'movies';
    
    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'name', 'description', 'actors', 'genres', 'trailer_youtube_id', 'image', 'published_at', 'user_id'
    ];
    
    // Relationship
    public function getThumbnail() {
        return $this->belongsTo('App\Models\Gallery', 'image', 'id')->withTrashed();
    }
    
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withTrashed();
    }

    public function getShowTimes() {
        return $this->hasMany('App\Models\MovieShowtime', 'movie_id', 'id');
    }
    
    // Static function
    public static function getMovieList($getTrashed = false) {
        if($getTrashed) {
            return self::with(['getThumbnail', 'getUser'])->withTrashed()->get();
        } else {
            return self::with(['getThumbnail', 'getUser'])->get();
        }
    }
    
    public static function getItem($id, $getTrashed = false) {
        if($getTrashed) {
            return self::withTrashed()->find($id);
        } else {
            return self::find($id);
        }
    }
    
    public static function updateNew($id, $data) {
        $movie = self::withTrashed()->find($id);
        
        if(is_null($movie)) {
            return self::create($data);
        }
        
        $movie->name = $data['name'];
        $movie->actors = $data['actors'];
        $movie->genres = $data['genres'];
        $movie->trailer_youtube_id = $data['trailer_youtube_id'];
        $movie->description = $data['description'];
        $movie->published_at = $data['published_at'];
        if($data['image'] != 0 && $movie->image != $data['image']) {
            Gallery::deleteFile($movie->image, true);
            $movie->image = $data['image'];
        }
        $movie->user_id = $data['user_id'];
        
        $movie->save();
        
        return $movie;
    }

    public static function changeStatus($id, $getTrashed = false) {
        if($getTrashed) {
            $movie = self::withTrashed()->find($id);
        } else {
            $movie = self::find($id);
        }

        if(!is_null($movie)) {
            if($movie->trashed()) {
                $movie->restore();
                $status = 1;
            } else {
                $movie->delete();
                $status = 0;
            }

            return response()->json(['result' => 1, 'status' => $status]);
        }

        return response()->json(['result' => 0, 'error' => 'Can not find any movie']);
    }

    public static function deleteMovie($id) {
        $movie = self::withTrashed()->find($id);

        if(is_null($movie)) {
            return array(
                'result' => 0,
                'error' => 'Can not find any movie'
            );
        }

        $showtimeList = $movie->getShowTimes;

        foreach($showtimeList as $showtime) {
            $showtime->delete();
        }

        $gallery = $movie->getThumbnail;

        if(!is_null($gallery)) {
            Gallery::clearGallery($gallery->id, 'movie', $movie->id);
        }

        $movie->forceDelete();

        return array('result' => 1);
    }
}
