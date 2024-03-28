<div class="row">
    <div class="form-group col-md-6">
        <label for="">Schema Title</label>
        <input type="text" required name="name" value="{{ old('name') ?? $dataSchema?->name }}" id="name"
            class="form-control" placeholder="Schema Title">
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="">Sub Categories</label>
        <select required name="sub_category_id" class="form-control " id="category_id">
            <option value="">Select Subcategory</option>
            @foreach ($subCategories as $subCategory)
                <option {{ old('sub_category_id') == $subCategory->id ? 'selected' : '' }} value="{{ $subCategory->id }}">
                    {{ $subCategory->name }}</option>
            @endforeach
        </select>
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-9 col-xl-6">
        <div class="checkbox-list">
            <label class="checkbox" title="If checked, any validation error will terminate import process!">
                <input type="checkbox" title="If checked, any validation error will terminate import process!">
                Force Validation On Data Entry
                <span class="ml-3"></span>
            </label>
        </div>
    </div>
</div>
