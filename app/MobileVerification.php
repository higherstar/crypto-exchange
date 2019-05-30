<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MobileVerification extends Model
{
    use SoftDeletes;

    protected $casts = [
        'extra_data' => 'array',
    ];

    protected $dates = ['expires_at'];

    /**
     * Scope only include active mobile verifications (non-expired)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', Carbon::now());
    }


    /**
     * Get the latest verification request for a given mobile number and user
     * @param $mobile_number
     * @param User $user
     * @param null $isVerified
     * @return mixed
     */
    public static function getLatestVerification($mobile_number, User $user, $isVerified = null)
    {
        $user_id = $user->id;

        $latest = self::where('mobile_number', $mobile_number)
            ->where('user_id', $user_id)
            ->active();

        if(is_null($isVerified))
        {
            return $latest
                ->latest()->first();
        }

        if($isVerified)
        {
            return $latest
                ->whereNotNull('verified_at')->latest()->first();
        }
        else
        {
            return $latest
                ->whereNull('verified_at')->latest()->first();
        }

    }
}
