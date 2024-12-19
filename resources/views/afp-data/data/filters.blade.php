<div class="filter-section mb-3">
    <form action="" method="GET">
        <div class="row">
            <div class="col-md-3">
                <label for="fieldFilter">Field</label>
                <input type="text" class="form-control" name="fieldFilter" value="{{ request('fieldFilter') }}" placeholder="Field">
            </div>
            <div class="col-md-3">
                <label for="provinceFilter">Province</label>
                <select id="provinceFilter" class="form-control" name="provinceFilter">
                    <option value="">Select Province</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province }}" {{ request('provinceFilter') == $province ? 'selected' : '' }}>{{ $province }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="sexFilter">Sex</label>
                <select id="sexFilter" class="form-control" name="sexFilter">
                    <option value="">Select Sex</option>
                    <option value="M" {{ request('sexFilter') == 'M' ? 'selected' : '' }}>Male</option>
                    <option value="F" {{ request('sexFilter') == 'F' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="ageFilter">Age (Years)</label>
                <select id="ageFilter" class="form-control" name="ageFilter">
                    <option value="">Select Age</option>
                    <option value="10" {{ request('ageFilter') == '10' ? 'selected' : '' }}>10-20</option>
                    <option value="20" {{ request('ageFilter') == '20' ? 'selected' : '' }}>20-40</option>
                    <option value="40" {{ request('ageFilter') == '40' ? 'selected' : '' }}>40-*</option>
                </select>
            </div>

            <div class="col-md-2 d-flex align-content-center align-items-end">
                <input type="submit" value="Filter" class="btn w-100 btn-primary">
            </div>
        </div>
    </form>
</div>
