<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'off_time',
        'paid_out',
        'description',
        'hours'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'off_period' => 'boolean',
        'paid_out' => 'boolean',
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
        return $query->where('off_time', 0)->where('paid_out', 0);
    }

    /**
     * Checks if the overtime was/is used
     *
     * @return bool
     */
    public function isUsed()
    {
        return (bool)$this->attributes['off_time'] || (bool)$this->attributes['paid_out'];
    }

    /**
     * Gets the days with remaining minutes
     *
     * @param $ids
     * @return array
     */
    public static function getDaysWithRemainder($arguments = [])
    {
        if (array_has($arguments, 'ids')) {
            $hours = Overtime::whereIn('id', array_get($arguments, 'ids'))->sum('hours');
        } elseif (array_has($arguments, 'hours')) {
            $hours = array_get($arguments, 'hours');
        } else {
            return false;
        }

        $minutes = convert_to_minutes($hours);
        $minutesLeft = $minutes % (60 * 8);
        $days = floor($minutes / (60 * 8));

        return compact('minutesLeft', 'days');
    }
}
