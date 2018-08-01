<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

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
    protected $with = [
        'company'
    ];

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
     * Gets the full name attribute
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
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

    /**
     * Checks if the user ia manager
     *
     * @return mixed
     */
    public function isManager()
    {
        return $this->manager;
    }
}
