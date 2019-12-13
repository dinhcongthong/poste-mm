<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Config;
use File;

class TownGallery extends Model
{

    const TYPE_SPACE = 1;
    const TYPE_FOOD = 2;
    const TYPE_MENU = 3;
    const TYPE_GENERAL = 4;

    protected $table = 'town_galleries';

    /**
    * About album_id: 1: Space, 2: Food, 3: Menu, 4: General
    */
    public $fillable = [
        'name', 'dir', 'town_id', 'album_id', 'user_id'
    ];

    // Relationship
    public function getPosteTown() {
        return $this->belongsTo('App\Models\PosteTown', 'town_id', 'id');
    }

    // Static
    public static function updateItem($url, $town_id, $album) {
        $imgData = Base::getUploadFilename($url);

        $data = array(
            'name' => $imgData['filename'],
            'dir' => $imgData['dir'],
            'town_id' => $town_id,
            'user_id' => Auth::user()->id,
            'album_id' => $album
        );

        $gallery = self::create($data);

        return $gallery ? $gallery->id : 0;
    }

    public static function saveTownID($id, $town_id) {
        $photo = self::find($id);

        if(is_null($photo)) {
            return false;
        }

        $photo->town_id = $town_id;
        $photo->save();

        return true;
    }

    public static function deleteItem($id) {
        $photo = self::find($id);

        if(is_null($photo)) {
            return true;
        }

        $path = Config::get('image.upload_path');

        if(!is_null($photo)) {
            $path = rtrim($path, '/');
            $name = trim($photo->name, '/');
            $dir = trim($photo->dir, '/');

            $path = $path.'/'.$dir.'/'.$name;
            // Gallery exists
            if(File::exists($path)) {
                // File exists
                $result = File::delete($path);

                if(!$result) {
                    return $result;
                }
            }

            //delete in database
            $result = $photo->delete();
        }

        return $result;
    }
}
