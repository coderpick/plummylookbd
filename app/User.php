<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    protected $guarded =['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName(){
        return 'slug';
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    //scope function
    public function scopeGetUser($query) {
        return $query->where('type','user')->get();
    }
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }


    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            if (!$user->roles()->get()->contains(2)) {
                $user->roles()->attach(2);
            }
        });
    }*/
}
