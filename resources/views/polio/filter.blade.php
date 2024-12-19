<div class="filter-section mb-3">
    <form action="" method="GET">
        <div class="row">
            @if (in_array('epid_number', $columns))
                <div class="col-md-3">
                    <label for="fieldEpidNumber">EPID Number</label>
                    <input type="text" class="form-control" name="fieldEpidNumber"
                        value="{{ request('fieldEpidNumber') }}" placeholder="EPID Number">
                </div>
            @endif
            @if (count($regions) > 0)
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
            @endif
            @if (count($zones) > 0)
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
            @endif
            @if (count($woredas) > 0)
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
            @endif
            @if (count($genders) > 0)
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
            @endif
            <div class="col-md-2 d-flex align-content-center align-items-end">
                <input type="submit" value="Filter" class="btn w-100 btn-primary">
            </div>
        </div>
    </form>
</div>
