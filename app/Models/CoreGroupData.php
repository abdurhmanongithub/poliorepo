<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreGroupData extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_name_region',
        'area_name_zone_somali',
        'area_name_zone_oromia',
        'area_name_zone_gambella',
        'area_name_zone_benshangul',
        'area_name_zone_snnp',
        'area_name_woreda_somali_afder',
        'area_name_woreda_somali_liben',
        'area_name_woreda_somali_shebele',
        'area_name_woreda_somali_siti',
        'area_name_woreda_somali_dollo',
        'area_name_woreda_somali_dawa',
        'area_name_woreda_oromia_borena',
        'area_name_woreda_oromia_kellem',
        'area_name_woreda_gambella_agnua',
        'area_name_woreda_gambella_nuer',
        'area_name_woreda_gambella_majang',
        'area_name_woreda_benshangul_assosa',
        'area_name_woreda_benshangul_metekel',
        'area_name_woreda_benshangul_kamashi',
        'area_name_woreda_snnp_bench_maji',
        'area_name_woreda_snnp_south_omo',
        'area_name_kebele',
        'area_name_village',
        'area_name_gps',
        'gps_latitude',
        'gps_longitude'
    ];
    public static function getLastImportBatch()
    {
        return OtherDataSource::where('source', Constants::OTHER_DATA_SOURCE_CORE_GROUP_DATA)->distinct('import_batch')->max('import_batch') ?? 0;
    }

    public static function getNextDataSource()
    {
        $lastImportBatch = self::getLastImportBatch();
        if ($lastImportBatch) {
            $lastValue = explode('_', $lastImportBatch);
            $lastValue = end($lastValue);
            $importBatch = $lastValue + 1;
        } else {
            $importBatch = 1;
        }

        $categoryAbbreviation = strtoupper(substr(Constants::OTHER_DATA_SOURCE_CORE_GROUP_DATA, 0, 2));
        $subCategoryAbbreviation = strtoupper(substr(Constants::OTHER_DATA_SOURCE_CORE_GROUP_DATA, 0, 2));
        return $categoryAbbreviation . '_' . $subCategoryAbbreviation . '_' . date('Y_m_d') . '_' . $importBatch;
    }
}
