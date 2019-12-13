<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GolfImage extends Model
{
      protected $table = 'golf_images';

    public $fillable = ['golf_id', 'gallery_id'];

    /* Relationship */
    public function getGolf() {
        return $this->belongsTo('App\Models\Golf', 'golf_id', 'id');
    }

    /* Static function */
    public static function addNew($data) {
        return self::create($data);
    }

    public static function getItem($golfId, $galleryId) {
        return self::where('golf_id', $golfId)->where('gallery_id', $galleryId)->orderBy('id', 'desc')->first();
    }

    public static function deleteByGolfId($golfId) {
        $golfImageList = self::where('golf_id', $golfId)->get();

        foreach($golfImageList as $item) {
            $item->delete();
        }

        return true;
    }
}
