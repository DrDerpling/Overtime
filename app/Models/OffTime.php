<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffTime extends Model
{

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
