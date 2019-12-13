<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TownMenuDetail extends Model
{
    protected $table = 'town_menu_details';

    public $fillable = [
        'menu_id', 'name', 'price', 'food_image'
    ];

    public function getImage() {
        return $this->belongsTo('App\Models\Gallery', 'food_image', 'id')->withTrashed();
    }
}
