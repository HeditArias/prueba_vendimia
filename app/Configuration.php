<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class configuration extends Model
{
	public $timestamps = false;
    protected $fillable = [
        'financing_rate', 'percentage_hitch', 'maximum_term',
    ];
}
