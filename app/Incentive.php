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
        'description', 'sponsor_id', 'day', 'available', 'gold_value'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sponsor()
    {
        return $this->belongsTo(User::class);
    }
}
