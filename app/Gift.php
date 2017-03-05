<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Gift
 * @package App
 */
class Gift extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['voucher_code', 'incentive_id', 'app_user_id', 'expiry_date', 'resolved'];
    /**
     * @var array
     */
    protected $casts = [
        'resolved' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function winner()
    {
        return $this->belongsTo(AppUser::class, 'app_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incentive()
    {
        return $this->belongsTo(Incentive::class);
    }
}
