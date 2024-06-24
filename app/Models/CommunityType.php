<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityType extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get all of the communities for the CommunityType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communities(): HasMany
    {
        return $this->hasMany(Community::class);
    }

}
