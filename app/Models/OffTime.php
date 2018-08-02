<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffTime extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'start_date',
        'end_date'
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
}
