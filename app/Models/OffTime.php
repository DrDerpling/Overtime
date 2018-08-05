<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OffTime extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'vacation_days_used'
    ];

    /**
     * @var array
     */
    public $dates = [
        'start_date',
        'end_date'
    ];

    /**
     * Morph relationship with Overtime class
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function overtimes()
    {
        return $this->morphToMany(Overtime::class, 'overtimable');
    }

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
     * Scope to check if a off times hasn't been used
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotExpired($query)
    {
        return $query->whereDate('start_date', '>', Carbon::now())
            ->whereDate('end_date', '>', Carbon::now())->orWhereNull('start_date');
    }

    /**
     * Gets the available days
     *
     * @return float|mixed
     */
    public function daysAvailable()
    {
        return getDays($this->overtimes->sum('hours')) + $this->vacation_days_used;
    }
}
