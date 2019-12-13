<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TownTag extends Model {
    protected $table = 'town_tags';

    public $fillable = [
        'town_id', 'tag_id'
    ];
}
