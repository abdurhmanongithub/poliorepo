<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Woreda extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
    /**
     * Get all of the communities for the Woreda
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communities(): HasMany
    {
        return $this->hasMany(Community::class);
    }

}
