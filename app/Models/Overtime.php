<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'off_period',
        'paid_out',
        'description',
        'minutes'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'off_period' => 'boolean',
        'paid_out'  => 'boolean',
    ];

    /**
     * Relationship method with User Class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for all active overtime
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
       return $query->where('off_period', 0)->where('paid_out', 0);
    }

    /**
     * Checks if the overtime was/is used
     *
     * @return bool
     */
    public function isUsed()
    {
        return (bool)$this->attributes['off_period'] || (bool)$this->attributes['paid_out'];
    }
}
