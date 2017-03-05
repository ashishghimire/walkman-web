<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppUser
 * @package App
 */
class AppUser extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'fb_id', 'fb_info', 'api_token', 'golds', 'total_distance', 'todays_distance', 'personal_best'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'fb_info' => 'array'
    ];
}
