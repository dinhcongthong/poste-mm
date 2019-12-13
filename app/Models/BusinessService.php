<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessService extends Model
{
    protected $table = 'business_services';

    public $fillable = [
        'business_id', 'name', 'description'
    ];
}
