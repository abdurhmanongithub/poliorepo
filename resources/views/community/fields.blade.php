<div class="form-group">
    <label for="community_type_id">Community type</label>
    <select name="community_type_id" class="form-control select2" id="community_type_id">
        <option value="" disabled {{ old('community_type_id', $community->community_type_id ?? '') == '' ? 'selected' : '' }}>Select</option>
        @foreach ($communityTypes as $communityType)
        <option value="{{ $communityType->id }}" {{ old('community_type_id', $community->community_type_id ?? '') == $communityType->id ? 'selected' : '' }}>
            {{ $communityType->name }}
        </option>
        @endforeach
    </select>
    @error('community_type_id')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="row">
    <div class="form-group col-6">
        <label for="full_name">Full Name</label>
        <input type="text" name="full_name" id="full_name" class="form-control" placeholder="full name" value="{{ old('full_name', $community->full_name ?? '') }}">
        @error('full_name')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group col-6">
        <label for="gender">Gender:</label>
        <select name="gender" class="form-control" required>
            <option value="" disabled {{ old('gender', $community->gender ?? '') == '' ? 'selected' : '' }}>Select</option>
            <option value="M" {{ old('gender', $community->gender ?? '') == 'M' ? 'selected' : '' }}>Male</option>
            <option value="F" {{ old('gender', $community->gender ?? '') == 'F' ? 'selected' : '' }}>Female</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="form-group col-6">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="{{ old('phone', $community->phone ?? '') }}">
        @error('phone')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group col-6">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="email" value="{{ old('email', $community->email ?? '') }}">
        @error('email')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="row">
    <div class="form-group col-6">
        <label for="woreda_id">Woreda</label>
        <select name="woreda_id" class="form-control select2" id="woreda_id">
            <option value="" disabled {{ old('woreda_id', $community->woreda_id ?? '') == '' ? 'selected' : '' }}>Select</option>
            @foreach ($woredas as $woreda)
            <option value="{{ $woreda->id }}" {{ old('woreda_id', $community->woreda_id ?? '') == $woreda->id ? 'selected' : '' }}>
                {{ $woreda->name }}
            </option>
            @endforeach
        </select>
        @error('woreda_id')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    {{-- <div class="form-group col-6">
        <label for="sub_category_id">Sub Category</label>
        <select name="sub_category_id" class="form-control " id="sub_category_id">
            <option value="" disabled {{ old('sub_category_id', $community->sub_category_id ?? '') == '' ? 'selected' : '' }}>Select</option>
            @foreach ($subCategories as $subCategory)
            <option value="{{ $subCategory->id }}" {{ old('sub_category_id', $community->sub_category_id ?? '') == $subCategory->id ? 'selected' : '' }}>
                {{ $subCategory->name }}
            </option>
            @endforeach
        </select>
        @error('sub_category_id')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div> --}}
</div>
