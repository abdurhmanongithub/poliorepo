<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the category associated with the SubCategory
     *
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all of the dataSchemas for the SubCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataSchemas(): HasMany
    {
        return $this->hasMany(DataSchema::class);
    }
    public function approvers()
    {
        return $this->belongsToMany(User::class);
    }
    /**
     * Get all of the knowledges for the SubCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function knowledges(): HasMany
    {
        return $this->hasMany(Knowledge::class);
    }
/**
 * Get the community that owns the SubCategory
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function community(): BelongsTo
{
    return $this->belongsTo(Community::class);
}
}
