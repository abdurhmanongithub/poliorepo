@extends('base')

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('columnSelector').addEventListener('change', function() {
                const selectedOptions = Array.from(this.selectedOptions).map(opt => opt.value);

                document.querySelectorAll('#dataTable th, #dataTable td').forEach(cell => {
                    cell.classList.add('d-none');
                });

                selectedOptions.forEach(option => {
                    document.querySelectorAll(`.field-${option}`).forEach(cell => {
                        cell.classList.remove('d-none');
                    });
                });
            });
        });
    </script>
@endpush

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon2-supermarket text-primary"></i>
                </span>
                <h3 class="card-label">Aggregated Data</h3>
            </div>
            <div class="card-toolbar">
                <div class="form-group">
                    <label for="columnSelector">Select Columns</label>
                    <select id="columnSelector" multiple class="form-control">
                        @foreach ($fields as $field)
                            <option value="{{ $field }}" selected>
                                {{ ucwords(str_replace('_', ' ', $field)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="filter-section mb-3">
                <form action="" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="fieldEpidNumber">EPID Number</label>
                            <input type="text" class="form-control" name="fieldEpidNumber"
                                value="{{ request('fieldEpidNumber') }}" placeholder="EPID Number">
                        </div>

                        <div class="col-md-3">
                            <label for="regionFilter">Region</label>
                            <select id="regionFilter" class="form-control" name="regionFilter">
                                <option value="">Select Region</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region }}"
                                        {{ request('regionFilter') == $region ? 'selected' : '' }}>
                                        {{ $region }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="zoneFilter">Zone</label>
                            <select id="zoneFilter" class="form-control" name="zoneFilter">
                                <option value="">Select Zone</option>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone }}"
                                        {{ request('zoneFilter') == $zone ? 'selected' : '' }}>
                                        {{ $zone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="woredaFilter">Woreda</label>
                            <select id="woredaFilter" class="form-control" name="woredaFilter">
                                <option value="">Select Woreda</option>
                                @foreach ($woredas as $woreda)
                                    <option value="{{ $woreda }}"
                                        {{ request('woredaFilter') == $woreda ? 'selected' : '' }}>
                                        {{ $woreda }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="genderFilter">Gender</label>
                            <select id="genderFilter" class="form-control" name="genderFilter">
                                <option value="">Select Gender</option>
                                @foreach ($genders as $gender)
                                    <option value="{{ $gender }}"
                                        {{ request('genderFilter') == $gender ? 'selected' : '' }}>
                                        {{ $gender }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 d-flex align-content-center align-items-end">
                            <input type="submit" value="Filter" class="btn w-100 btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered table-hover" id="dataTable">
                <thead>
                    <tr>
                        @foreach ($fields as $field)
                            <th class="field-{{ $field }}">{{ ucwords(str_replace('_', ' ', $field)) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mergedData as $row)
                        <tr>
                            @foreach ($fields as $field)
                                <td class="field-{{ $field }}">{{ $row[$field] ?? '' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div>{{ $mergedData->links() }}</div>
        </div>
    </div>
@endsection
