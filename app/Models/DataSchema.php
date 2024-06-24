<?php

namespace App\Models;

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

    public function getListOfAttributes()
    {
        $array = $this->structure;
        return $array ?? [];
    }
    public function getLastImportBatch()
    {
        return DataSource::where('data_schema_id', $this->id)->distinct('import_batch')->max('import_batch') ?? 0;
    }
    public function getDataBatch()
    {
        return $this->dataSources()->pluck('import_batch');
    }

    public function dataSources()
    {
        return $this->hasMany(DataSource::class);
    }

    public function getNextDataSource()
    {
        $lastImportBatch = $this->getLastImportBatch();
        if ($lastImportBatch) {
            $lastValue = explode('_', $lastImportBatch);
            $lastValue = end($lastValue);
            $importBatch = $lastValue + 1;
        } else {
            $importBatch = 1;
        }

        $categoryAbbreviation = strtoupper(substr($this->subCategory->category->name, 0, 2));
        $subCategoryAbbreviation = strtoupper(substr($this->subCategory->name, 0, 2));
        return $categoryAbbreviation . '_' . $subCategoryAbbreviation . '_' . date('Y_m_d') . '_' . $importBatch;
    }

    public function totalCommuityMembers()
    {

        return ($this->subCategory->communities()->count());
    }
}
