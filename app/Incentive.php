<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Incentive
 * @package App
 */
class Incentive extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'description', 'user_id', 'day', 'available', 'gold_value', 'photo'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'available' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sponsor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gifts()
    {
        return $this->hasMany(Gift::class);
    }
}
