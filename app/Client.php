<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    protected $fillable = [
        'name', 'last_name', 'mother_last_name', 'rfc',
    ];
}
