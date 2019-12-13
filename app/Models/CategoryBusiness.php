<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryBusiness extends Model
{
    protected $table = 'category_businesses';

    public $fillable = ['business_id', 'category_id'];
}
