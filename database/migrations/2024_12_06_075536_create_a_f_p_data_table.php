<?php

use App\Models\OtherDataSource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('a_f_p_data', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OtherDataSource::class)->nullable();
            $table->text('epid_number')->nullable();
            $table->text('laboratory_id_number')->nullable();
            $table->text('province')->nullable();
            $table->text('district')->nullable();
            $table->text('patients_names')->nullable();
            $table->date('date_of_onset')->nullable();
            $table->date('date_of_last_opv_dose')->nullable();
            $table->text('opv_doses')->nullable();
            $table->date('date_stool_collected')->nullable();
            $table->date('date_stool_sent_from_field')->nullable();
            $table->date('date_stool_received_in_lab')->nullable();
            $table->text('case_or_contact')->nullable();
            $table->text('specimen_number')->nullable();
            $table->text('specimen_condition_on_receipt')->nullable();
            $table->text('final_cell_culture_result')->nullable();
            $table->date('date_final_cell_culture_results')->nullable();
            $table->text('final_combined_itd_result')->nullable();
            $table->text('itd_mixture')->nullable();
            $table->date('date_isolate_sent_for_sequencing')->nullable();
            $table->date('date_isolate_received_in_lab_for_sequencing')->nullable();
            $table->text('nucleotide_difference_sabin1')->nullable();
            $table->text('nucleotide_difference_sabin2')->nullable();
            $table->text('nucleotide_difference_sabin3')->nullable();
            $table->text('closest_match_w1_epid')->nullable();
            $table->text('closest_match_w2_epid')->nullable();
            $table->text('closest_match_w3_epid')->nullable();
            $table->text('closest_match_vdpv1_epid')->nullable();
            $table->text('closest_match_vdpv2_epid')->nullable();
            $table->text('closest_match_vdpv3_epid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_f_p_data');
    }
};
