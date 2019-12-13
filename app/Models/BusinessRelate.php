<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessRelate extends Model
{
    protected $table = 'business_related';

    public $fillable = [
        'name', 'address', 'phone', 'email', 'website', 'business_id'
    ];
}
