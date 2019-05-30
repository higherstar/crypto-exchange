<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $dates = ['deleted_at','mobile_number_verified_at', 'verified_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function verifications()
    {
        return $this->hasMany(Verification::class);
    }

    public function getVerifiedAttribute()
    {
        return $this->verifications()->where('stage', Verification::STAGE_APPROVED)->count() > 0 ? true : false;
    }

    public function getVerificationStageAttribute()
    {
        $verification = $this->verifications()->currentVerification()->first();

        if (isset($verification))
            return $verification->stage;
        else
            return Verification::STAGE_NOT_STARTED;
    }

}
