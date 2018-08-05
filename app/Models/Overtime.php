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
        return $query->where(['off_time' => 0, 'paid_out' => 0]);
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
        return ($this->off_time && $this->paid_out);
    }

    public static function getRequiredOverTimes($days, $offTime)
    {
        $user = auth()->user();
        $overtimes = $user->overtimes()->unused()->get();
        if ($overtimes->sum('hours') === 0) {
            return collect();
        }
        //Check to see if total days are available
        if (getDays($overtimes->sum('hours')) < $days) {
            $remainingHours = getRemainingMinutes($overtimes->sum('hours')) / 60;
            $remainingOvertime = $overtimes->where('hours', $remainingHours)->first();
            if ($remainingOvertime) {
                $overtimes->reject($remainingOvertime);
            } else {
                $remainingOvertimes = Overtime::calcRequiredOvertime($remainingHours, $overtimes);
                if ($remainingOvertimes) {
                    $overtimes->reject($remainingOvertimes);
                }
            }
            return $overtimes;
        };

        $overtimes = Overtime::calcRequiredOvertime($days * 8, $overtimes);
        if ($overtimes) {
            return $overtimes;
        }

        return false;
    }

    /**
     * Returns a collection with all overtime models matching the hours provided
     *
     * @param $hours
     * @return $this|bool
     */
    public static function calcRequiredOvertime($hours, $overtimes)
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        if ($overtimes->sum('hours') < $hours || !$hours || !$overtimes->count()) {
            return false;
        }

        // if all the hours are available we need to get the correct number of overtime
        $_overtimes = collect();

        // Lower the number below 3 and save overtime used
        foreach ($overtimes->sortByDesc('hours') as $key => $overtime) {
            if ($hours <= 3) {
                break;
            }
            $hours -= $overtime->hours;
            $_overtimes->push($overtime);
            $overtimes->forget($key);
        }
        // Check if we have a overtime with the required hours left
        if ($overtime = $overtimes->where('hours', $hours)->first()) {
            $_overtimes->push($overtime);
        } else {
            //Split up the decimal number
            if (is_float($hours) && floor($hours) != $hours) {
                list($whole, $decimal) = explode('.', $hours);
            } else {
                $whole = $hours;
                $decimal = 0;
            }
            // Check if we have a overtime with the required decimal
            if ($decimalOvertime = $overtimes->where('hours', $decimal)->first() && $decimal !== 0) {
                $hours -= $decimalOvertime->hours;
                $_overtimes->push($decimalOvertime);
                // Check if we have a whole number left of the remaining hours
                if ($remainingOvertime = $overtimes->where('hours', $hours)->first()) {
                    return $_overtimes->push($remainingOvertime);
                } else {
                    //IF we don't have the required over time hours we then have to create one
                    $maxOvertime = $overtimes->max('hours');
                    $user->overtimes()->create(
                        [
                            'hours' => $maxOvertime->hours - $hours,
                            'description' => 'Overtime created by off time',
                            'off_time' => 0,
                        ]
                    );
                    $maxOvertime->update(['hours' => $hours]);

                    $_overtimes->push($maxOvertime);
                }
            } else {
                //IF we don't have the required over time hours we then have to create one
                $maxOvertime = $overtimes->where('hours', $overtimes->max('hours'))->first();

                if ($maxOvertime->hours > $hours) {
                    $user->overtimes()->create(
                        [
                            'hours' => $maxOvertime->hours - $hours,
                            'description' => 'Overtime created by off time',
                            'off_time' => 0,
                        ]
                    );
                    $maxOvertime->update(['hours' => $hours]);
                    $_overtimes->push($maxOvertime);
                } else {
                    //Stack up the lowest numbers
                    foreach ($overtimes->sortBy('hours') as $key => $overtime) {
                        if ($hours > 0) {
                            if ($hours - $overtime->hours > 0) {
                                $hours -= $overtime->hours;
                                $_overtimes->push($overtime);
                                $overtimes->forget($key);
                            } else {
                                break;
                            }
                        } else {
                            break;
                        }
                    }
                    if ($hours > 0) {
                        //IF we don't have the required over time hours we then have to create one
                        $maxOvertime = $overtimes->where('hours', $overtimes->max('hours'))->first();
                        if ($maxOvertime->hours > $hours) {
                            $user->overtimes()->create(
                                [
                                    'hours' => $maxOvertime->hours - $hours,
                                    'description' => 'Overtime created by off time',
                                    'off_time' => 0,
                                ]
                            );
                            $maxOvertime->update(['hours' => $hours]);
                            $_overtimes->push($maxOvertime);
                        }
                    }
                }
            }
        }

        return $_overtimes;
    }
}
