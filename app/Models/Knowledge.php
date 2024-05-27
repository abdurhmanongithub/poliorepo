<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Knowledge extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get the subCategory associated with the Knowledge
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, );
    }
    /**
     * Get the knowledgeType that owns the Knowledge
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function knowledgeType(): BelongsTo
    {
        return $this->belongsTo(KnowledgeType::class);
    }



}
