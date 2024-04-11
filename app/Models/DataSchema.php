<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataSchema extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'structure' => 'json',
    ];

    /**
     * Get the subCategory that owns the DataSchema
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }
    /**
     * Get all of the datas for the DataSchema
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function datas(): HasMany
    {
        return $this->hasMany(Data::class);
    }

    public function getListOfAttributes(){
        $array = $this->structure;
        return $array??[];
    }
    public function getLastImportBatch(){
        return Data::distinct('import_batch')->max('import_batch')??0;
    }
    public function getDataBatch(){
        return $this->datas()->distinct('import_batch')->pluck('import_batch');
    }

}
