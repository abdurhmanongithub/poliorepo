<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AFPData extends Model
{
    use HasFactory;
    protected $fillable = [
        'epid_number',
        'laboratory_id_number',
        'province',
        'district',
        'patients_names',
        'date_of_onset',
        'date_of_last_opv_dose',
        'opv_doses',
        'date_stool_collected',
        'date_stool_sent_from_field',
        'date_stool_received_in_lab',
        'case_or_contact',
        'specimen_number',
        'specimen_condition_on_receipt',
        'final_cell_culture_result',
        'date_final_cell_culture_results',
        'final_combined_itd_result',
        'itd_mixture',
        'date_isolate_sent_for_sequencing',
        'date_isolate_received_in_lab_for_sequencing',
        'nucleotide_difference_sabin1',
        'nucleotide_difference_sabin2',
        'nucleotide_difference_sabin3',
        'closest_match_w1_epid',
        'closest_match_w2_epid',
        'closest_match_w3_epid',
        'closest_match_vdpv1_epid',
        'closest_match_vdpv2_epid',
        'closest_match_vdpv3_epid'
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
