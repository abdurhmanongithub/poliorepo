@extends('afp-data.sublayout')

@push('js')
    <script>
        $(document).ready(function() {
            // Handle fullscreen button click
            $('.fullscreen-btn').click(function() {
                // Clone the card body content (datatable)
                var cardBodyContent = $('#datatable-card-body').html();
                // Set the content in the fullscreen modal body
                $('#fullscreenModal .modal-body').html(cardBodyContent);
                // Show the fullscreen modal
                $('#fullscreenModal').modal('show');
            });
        });

        function eraseData() {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#eraseForm').submit();
                }
            });
        }
        $('#columnSelector').on('change', function() {
            const selectedOptions = $(this).val();

            $('#dataTable th, #dataTable td').addClass('d-none');

            selectedOptions.forEach(option => {
                console.log(option);
                $(`#dataTable .${option}`).removeClass('d-none');
            });
        });
    </script>
@endpush
@section('nav_content')
    @include('data_schema.data.full_screen_modal')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon2-supermarket text-primary"></i>
                </span>
                <h3 class="card-label">{{ 'Core Group Data' }}</h3>
            </div>
            <div class="card-toolbar">
                <a href="#" class="btn btn-primary btn-sm mr-2 fullscreen-btn"><i class="fa fa-expand-wide mr-2"></i>
                    Full Screen</a>
                <div class="dropdown dropdown-inline mr-2">
                    <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                        fill="#000000" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Action</button>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <ul class="navi flex-column navi-hover py-2">
                            <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choose
                                an option:</li>

                            <li class="navi-item">
                                <a href="{{ route('afp-data.import.view') }}" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="fal fa-file-import"></i>
                                    </span>
                                    <span class="navi-text">Import Data</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" data-toggle="modal" data-target="#exportDataModal" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="fal fa-file-export"></i>
                                    </span>
                                    <span class="navi-text">Export Data</span>
                                </a>
                            </li>

                            <li class="navi-item">
                                <a href="#" onclick="eraseData()" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="fal fa-trash text-danger"></i>
                                    </span>
                                    <span class="navi-text  text-danger">Erase Data</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label for="columnSelector">Select Columns</label>
                    <select id="columnSelector" multiple>
                        <option selected value="id">#</option>
                        <option selected value="field">Field</option>
                        <option selected value="epid_number">Epidemic Number</option>
                        <option selected value="laboratory_id_number">Laboratory ID Number</option>
                        <option selected value="patients_names">Patients' Names</option>
                        <option selected value="province">Province</option>
                        <option selected value="district">District</option>
                        <option value="date_of_onset">Date of Onset</option>
                        <option value="date_stool_collected">Date Stool Collected</option>
                        <option value="date_stool_received_in_lab">Date Stool Received in Lab</option>
                        <option value="case_or_contact">Case or Contact</option>
                        <option value="specimen_number">Specimen Number</option>
                        <option value="specimen_condition_on_receipt">Specimen Condition on Receipt</option>
                        <option value="final_cell_culture_result">Final Cell Culture Result</option>
                        <option value="final_combined_itd_result">Final Combined ITD Result</option>
                        <option value="sex">Sex</option>
                        <option value="age_in_years">Age in Years</option>
                        <option value="age_in_months">Age in Months</option>
                        <option value="opv_doses">OPV Doses</option>
                        <option value="date_stool_sent_from_field">Date Stool Sent from Field</option>
                        <option value="date_final_cell_culture_results">Date Final Cell Culture Results</option>
                        <option value="itd_mixture">ITD Mixture</option>
                        <option selected ="action">Action</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive" id="datatable-card-body">
            @include('afp-data.data.filters')
            <table class="table table-sm table-bordered table-hover table-checkable" id="datatable"
                style="margin-top: 13px !important">
                <thead>
                    <tr>
                        <td class="id text-sm">#</td>
                        <td class="field text-sm">Field</td>
                        <td class="epid_number text-sm">Epid Number</td>
                        <td class="laboratory_id_number text-sm">Laboratory Id Number</td>
                        <td class="patients_names text-sm">Patients Names</td>
                        <td class="province text-sm">Province</td>
                        <td class="district text-sm">District</td>
                        <td class="date_of_onset text-sm d-none">Date Of Onset</td>
                        <td class="date_stool_collected text-sm d-none">Date Stool Collected</td>
                        <td class="date_stool_received_in_lab text-sm d-none">Date Stool Received In Lab</td>
                        <td class="case_or_contact text-sm d-none">Case Or Contact</td>
                        <td class="specimen_number text-sm d-none">Specimen Number</td>
                        <td class="specimen_condition_on_receipt text-sm d-none">Specimen Condition On Receipt</td>
                        <td class="final_cell_culture_result text-sm d-none">Final Cell Culture Result</td>
                        <td class="final_combined_itd_result text-sm d-none">Final Combined Itd Result</td>
                        <td class="sex text-sm d-none">Sex</td>
                        <td class="age_in_years text-sm d-none">Age In Years</td>
                        <td class="age_in_months text-sm d-none">Age In Months</td>
                        <td class="opv_doses text-sm d-none">Opv Doses</td>
                        <td class="date_stool_sent_from_field text-sm d-none">Date Stool Sent From Field</td>
                        <td class="date_final_cell_culture_results text-sm d-none">Date Final Cell Culture Results</td>
                        <td class="itd_mixture text-sm d-none">Itd Mixture</td>
                        <td class="action text-sm">Actions</td>
                    </tr>
                    @foreach ($datas as $key => $data)
                        <tr>
                            <td class="id text-sm">{{ $data->id }}</td>
                            <td class="field text-sm">{{ $data->field }}</td>
                            <td class="epid_number text-sm">{{ $data->epid_number }}</td>
                            <td class="laboratory_id_number text-sm">{{ $data->laboratory_id_number }}</td>
                            <td class="patients_names text-sm">{{ $data->patients_names }}</td>
                            <td class="province text-sm">{{ $data->province }}</td>
                            <td class="district text-sm">{{ $data->district }}</td>
                            <td class="date_of_onset text-sm d-none">{{ $data->date_of_onset }}</td>
                            <td class="date_stool_collected text-sm d-none">{{ $data->date_stool_collected }}</td>
                            <td class="date_stool_received_in_lab text-sm d-none">{{ $data->date_stool_received_in_lab }}
                            </td>
                            <td class="case_or_contact text-sm d-none">{{ $data->case_or_contact }}</td>
                            <td class="specimen_number text-sm d-none">{{ $data->specimen_number }}</td>
                            <td class="specimen_condition_on_receipt text-sm d-none">
                                {{ $data->specimen_condition_on_receipt }}</td>
                            <td class="final_cell_culture_result text-sm d-none">{{ $data->final_cell_culture_result }}
                            </td>
                            <td class="final_combined_itd_result text-sm d-none">{{ $data->final_combined_itd_result }}
                            </td>
                            <td class="sex text-sm d-none">{{ $data->sex }}</td>
                            <td class="age_in_years text-sm d-none">{{ $data->age_in_years }}</td>
                            <td class="age_in_months text-sm d-none">{{ $data->age_in_months }}</td>
                            <td class="opv_doses text-sm d-none">{{ $data->opv_doses }}</td>
                            <td class="date_stool_sent_from_field text-sm d-none">{{ $data->date_stool_sent_from_field }}
                            </td>
                            <td class="date_final_cell_culture_results text-sm d-none">
                                {{ $data->date_final_cell_culture_results }}</td>
                            <td class="itd_mixture text-sm">{{ $data->itd_mixture }}</td>
                            <td class="action text-sm">

                            </td>
                        </tr>
                    @endforeach
                </thead>
            </table>
        </div>
        <div class="card-footer">
            <div class="">{{ $datas->links() }}</div>
        </div>
    </div>
@endsection
