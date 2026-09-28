<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'contact', 'nickname', 'birthday', 'gender', 'social_id', 'email_verify_code', 'email_verified_at'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function members ()
    {
        return $this->hasMany(Members::class);
    }

    public function lectures ()
    {
        return $this->hasMany(Lecture::class);
    }

    public function messages ()
    {
        return $this->hasMany(Message::class);
    }

    public function answers () {
        return $this->hasMany(Answer::class);
    }
}
