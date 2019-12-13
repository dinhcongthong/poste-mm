<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meta extends Model
{
    use SoftDeletes;

    protected $table = 'metas';

	protected $dates = ['deleted_at'];

	public $fillable = [
		'url', 'title', 'description', 'keywords', 'type', 'image'
	];
}
