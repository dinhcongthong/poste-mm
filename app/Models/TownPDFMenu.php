<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Config;
use File;

class TownPDFMenu extends Model
{
    protected $table = 'town_pdf_menus';

    public $fillable = ['name', 'dir', 'town_id'];

    // Relation
    public function getTown() {
        return $this->belongsTo('App\Models\PosteTown', 'town_id', 'id');
    }

    // Static function

    public static function deletePDF($id) {
        $path = Config::get('image.upload_path');
        $file = self::find($id);

        $result = false;

        if(!is_null($file)) {
            $path = rtrim($path, '/');
            $name = trim($file->name, '/');
            $dir = trim($file->dir, '/');

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
            $result = $file->delete();
        }

        return $result;
    }
}
