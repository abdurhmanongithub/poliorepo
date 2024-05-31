<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsHistory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function information()
    {
        return $this->where('type', Constants::INFORMATION);
    }
    public function message()
    {
      return   $this->where('type', Constants::MESSAGE);
    }
    /**
     * Get the community that owns the SmsHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }
    /**
     * Get the community that owns the SmsHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function knowledge(): BelongsTo
    {
        return $this->belongsTo(Knowledge::class);
    }
}
