<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AFPData extends Model
{
    use HasFactory;
    protected $fillable = [
        'other_data_source_id', 
        'field',
        'epid_number',
        'laboratory_id_number',
        'patients_names',
        'province',
        'district',
        'date_of_onset',
        'date_stool_collected',
        'date_stool_received_in_lab',
        'case_or_contact',
        'specimen_number',
        'specimen_condition_on_receipt',
        'final_cell_culture_result',
        'final_combined_itd_result',
        'sex',
        'age_in_years',
        'age_in_months',
        'opv_doses',
        'date_stool_sent_from_field',
        'date_final_cell_culture_results',
        'itd_mixture',
    ];
    public static function getLastImportBatch()
    {
        return OtherDataSource::where('source', Constants::OTHER_DATA_SOURCE_AFP_DATA)->distinct('import_batch')->max('import_batch') ?? 0;
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

        $categoryAbbreviation = strtoupper(substr(Constants::OTHER_DATA_SOURCE_AFP_DATA, 0, 2));
        $subCategoryAbbreviation = strtoupper(substr(Constants::OTHER_DATA_SOURCE_AFP_DATA, 0, 2));
        return $categoryAbbreviation . '_' . $subCategoryAbbreviation . '_' . date('Y_m_d') . '_' . $importBatch;
    }
}
