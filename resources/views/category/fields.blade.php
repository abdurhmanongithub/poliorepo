<div class="form-group">
    <label for="">Category Name</label>
    <input type="text" name="name" value="{{ old('name') ?? $category?->name }}" id="name" class="form-control"
        placeholder="Category Name">
    @error('name')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="">Description</label>
    <textarea name="description" id="description" class="form-control">{{ old('description') ?? $category?->description }}</textarea>
    @error('description')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
