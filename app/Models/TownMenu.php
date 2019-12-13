<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TownMenu extends Model
{
    protected $tables = 'town_menus';

    public $fillable = [
        'name', 'town_id'
    ];

    public function getDetail() {
        return $this->hasMany('App\Models\TownMenuDetail', 'menu_id', 'id');
    }
}
