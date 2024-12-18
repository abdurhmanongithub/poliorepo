<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Community extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get the communityType that owns the Community
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function communityType(): BelongsTo
    {
        return $this->belongsTo(CommunityType::class);
    }
    public function woreda(): BelongsTo
    {
        return $this->belongsTo(Woreda::class);
    }
    // public function subCategory(): BelongsTo
    // {
    //     return $this->belongsTo(SubCategory::class);
    // }
    /**
     * Get all of the smsHistories for the Community
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function smsHistories(): HasMany
    {
        return $this->hasMany(SmsHistory::class);
    }

}
