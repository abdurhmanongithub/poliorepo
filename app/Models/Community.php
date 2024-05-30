<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

}
