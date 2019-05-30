<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verification extends Model
{
    use softDeletes;
    //

    protected $dates = ['deleted_at', 'completed_at'];

    #region DOCUMENT_TYPES
    const DOCUMENT_TYPES = ['CIVIL_ID', 'PASSPORT'];

    const CIVIL_ID = "CIVIL_ID";
    const PASSPORT = "PASSPORT";
    #endregion

    #region VERIFICATION_STAGES
    const STAGE_NOT_STARTED = "NOT_STARTED";
    const STAGE_CANCELED = "CANCELED";
    const STAGE_REVIEW = "REVIEW";
    const STAGE_EXTENDED_REVIEW = "EXTENDED_REVIEW";
    const STAGE_APPROVED = "APPROVED";
    const STAGE_REJECTED = "REJECTED";
    #endregion

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVerificationsInProgress( $query)
    {
        return $query->whereIn('stage',[static::STAGE_REVIEW, static::STAGE_EXTENDED_REVIEW]);
    }

    public function scopeCompletedVerifications($query)
    {
        return $query->whereIn('stage', [static::STAGE_APPROVED, static::STAGE_REJECTED]);
    }

    public function scopeCurrentVerification($query)
    {
        return $query->verificationsInProgress()->latest()->take(1);
    }

    public function scopeVerificationStage($query)
    {
        // GET VERIFICATION STAGE OF THE USER
    }
}
