<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'manager'
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
     * Eagerloads specific relations
     *
     * @var array
     */

    protected $casts = [
        'manager' => 'boolean'
    ];

    /**
     * Relationship method with company class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relationship method with Overtime class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }

    /**
     * Relationship method with offTime class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offTimes()
    {
        return $this->hasMany(OffTime::class);
    }

    /**
     * Relationship method with Payout class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payouts()
    {
        return $this->hasMany(Payout::class);
    }

    /**
     * Gets the full name attribute
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    /**
     * Gets all unused overtime hours
     *
     * @return float
     */
    public function getOvertimeHoursAttribute()
    {
        return $this->overtimes()->unused()->sum('hours');
    }

    /**
     * Returns overtime hours with no decimals
     *
     * @return float
     */
    public function getOvertimeHoursFlooredAttribute()
    {
        return floor($this->overtimeHours);
    }

    /**
     * Gets als unused overtime minutes
     *
     * @return int
     */
    public function getOvertimeMinutesAttribute()
    {
        return convert_to_minutes($this->overtimeHours) %  60;
    }

    /**
     * Sets password
     *
     * @param $string
     */
    public function setPasswordAttribute($string)
    {
        $this->attributes['password'] = bcrypt($string);
    }

    public function getPayoutHoursThisMonthAttribute()
    {
        $payoutDay = $this->company->payout_day;
        $payoutDate = Carbon::now()->day($payoutDay);
        $prevPayoutDate = Carbon::createFromTimestamp($payoutDate->getTimestamp())->subMonth();
        return $this->payouts()->whereDate('created_at', '<', $payoutDate)
                ->whereDate('created_at', '>', $prevPayoutDate)->sum('minutes') / 60;
    }

    /**
     * Checks if the user ia manager
     *
     * @return mixed
     */
    public function isManager()
    {
        return $this->manager;
    }

    public function updateVacationDays($offTime, $days)
    {
        if ($this->vacation_days > $days) {
            $offTime->update(['vacation_days_used' => $days]);
            $this->vacation_days = $this->vacation_days - $days;
            $this->save();
            return 0;
        } else {
            $this->update(['vacation_days' => 0]);
            return $days - $this->vacation_days;
        }
    }
}
