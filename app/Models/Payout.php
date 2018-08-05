<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payout extends Model
{
    protected $fillable = [
        'minutes'
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

    public static function getUpcomingPayoutHours()
    {
        $payoutDay = auth()->user()->company->payout_day;
        $payoutDate = Carbon::now()->day($payoutDay);
        $prevPayoutDate = Carbon::createFromTimestamp($payoutDate->getTimestamp())->subMonth();
        return Payout::whereDate('created_at', '<', $payoutDate)
                ->whereDate('created_at', '>', $prevPayoutDate)->sum('minutes') / 60;
    }
}
