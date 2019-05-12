<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $fillable = [
        'id', 'description', 'model', 'price', 'existence',
    ];
}
