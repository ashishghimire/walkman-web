<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check if the user is admin
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incentives()
    {
        return $this->hasMany(Incentive::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function gifts()
    {
        return $this->hasManyThrough(Gift::class, Incentive::class);
    }

    /**
     * @return mixed
     */
    public function getAvailableGiftsAttribute()
    {
        return $this->gifts->where('resolved', false);
    }
}
