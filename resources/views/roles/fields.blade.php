<div class="form-group">
    <label for="">Role Name</label>
    <input type="text" name="name" value="{{ old('name') ?? $role?->name }}" id="name" class="form-control" placeholder="role Name">
    @error('name')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
