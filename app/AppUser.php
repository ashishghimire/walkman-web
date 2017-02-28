<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    protected $fillable = [
        'fb_id', 'fb_info', 'api_token', 'golds', 'total_distance', 'todays_distance', 'personal_best'
    ];

    protected $casts = [
    	'fb_info' => 'json'
    ];
}
