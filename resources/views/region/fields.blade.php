<div class="form-group">
    <label for=""> Name</label>
    <input type="text" name="name" value="{{ old('name') ?? $region?->name }}" id="name" class="form-control" placeholder="region Name">
    @error('name')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>


<div class="form-group">
    <label for=""> Code</label>
    <input type="text" name="code" value="{{ old('code') ?? $region?->code }}" id="code" class="form-control" placeholder="region Name">
    @error('code')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
