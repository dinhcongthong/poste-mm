<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TownRegClose extends Model
{
    protected $table = 'town_reg_closes';
    
    public $fillable = ['town_id', 'start_date', 'end_date', 'note'];
}
