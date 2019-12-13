<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessGallery extends Model
{
    protected $table = 'business_galleries';

    public $fillable = [
        'business_id', 'gallery_id'
    ];

    public function getImage() {
        return $this->belongsTo('App\Models\Gallery', 'gallery_id', 'id')->withTrashed();
    }
}
