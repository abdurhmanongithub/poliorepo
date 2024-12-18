<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Broadcast extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the community that owns the Broadcast
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    /**
     * Get the content that owns the Broadcast
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    public function getStatus()
    {
        if ($this->status == Constants::BROADCAST_STATUS_PENDING) {
            return '<span class="badge badge-primary">Pending</span>';
        }
        if ($this->status == Constants::BROADCAST_STATUS_SENT) {
            return '<span class="badge badge-success">Sent</span>';
        }
        if ($this->status == Constants::BROADCAST_STATUS_FAILED) {
            return '<span class="badge badge-danger">Failed</span>';
        }
    }
}
