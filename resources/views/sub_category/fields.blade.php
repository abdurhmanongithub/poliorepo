<div class="row">
    <div class="form-group col-md-6">
        <label for="">Sub Category Name</label>
        <input type="text" name="name" value="{{ old('name') ?? $subCategory?->name }}" id="name" class="form-control"
            placeholder="Sub Category Name">
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="">Categories</label>
        <select name="category_id" class="form-control " id="category_id">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
            <option {{ $category->id==$subCategory?->id?'selected':'' }} value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group">
    <label for="">Description</label>
    <textarea name="description" id="description" class="form-control">{{ old('description') ?? $subCategory?->description }}</textarea>
    @error('description')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
