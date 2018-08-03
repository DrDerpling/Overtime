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
     * Morph relationship with OffTime
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function offTimes()
    {
        return $this->morphedByMany(OffTime::class, 'overtimable');
    }

    /**
     * Morph relationship with Payout
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function payouts()
    {
        return $this->morphedByMany(Payout::class, 'overtimable');
    }

    /**
     * Scope for all active overtime
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnused($query)
    {
        return $query->doesntHave('payouts')->doesntHave('offTimes');
    }

    /**
     * Scope that detaches all morphs
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDetachAllMorphs($query)
    {
         $query->offTimes()->detach();
         $query->payouts()->detach();

         return $query;
    }

    /**
     * Checks if the overtime was/is used
     *
     * @return bool
     */
    public function isUsed()
    {
        return !$this->has('payouts')->has('offTimes');
    }
}
