<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * Relationship method with user class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Eagerloads relations
     *
     * @var array
     */
    protected $with = [
        'users'
    ];

    /**
     * Checks if the user is part of company
     *
     * @param $user
     * @return mixed
     */
    public function isPartOfCompany($user)
    {
        return $this->users->has($user->id);
    }

    /**
     * Checks if the user is the owner of a company
     *
     * @param $user
     * @return bool
     */
    public function isOwner($user)
    {
        return $this->isPartOfCompany($user) && $user->mangaer;
    }


}
