<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessMap extends Model
{
    protected $table = 'business_maps';

    public $fillable = [
        'address', 'map', 'route_guide', 'business_id', 'image_route_guide'
    ];

    public function getImage() {
        return $this->belongsTo('App\Models\Gallery', 'image_route_guide', 'id')->withTrashed();
    }
}
