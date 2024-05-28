<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get all of the dataSchemas for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }


    public function dataSchema()
    {
        return $this->hasManyThrough(DataSchema::class, SubCategory::class);
    }

    public function getDataCount()
    {
        $dataSchemaIds = $this->dataSchema->pluck('id');
        if (count($dataSchemaIds) > 0)
            return Data::whereIn('data_schema_id', $dataSchemaIds)->count();
        return 0;
    }

}
