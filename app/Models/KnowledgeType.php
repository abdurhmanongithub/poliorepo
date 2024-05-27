<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgeType extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get the knowledgeType associated with the Knowledge
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function knowledgeType(): HasMany
    {
        return $this->hasMany(Knowledge::class);
    }
}
