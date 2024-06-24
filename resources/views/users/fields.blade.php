<div class="form-group">
    <label for="">Full Name</label>
    <input type="text" name="full_name" value="{{ old('full_name') ?? $user?->full_name }}" id="full_name" class="form-control" placeholder="Full Name" required>
    @error('full_name')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="">Email</label>
    <input type="email" name="email" value="{{ old('email') ?? $user?->email }}" id="email" class="form-control" placeholder="Email" required>
    @error('email')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="">Phone</label>
    <input type="phone" name="phone" value="{{ old('phone') ?? $user?->phone }}" id="email" class="form-control" placeholder="phone number" required>
    @error('phone')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="roles">Role/User-Type</label>
    <select name="roles[]" id="roles" class="form-control select2 @error('roles') is-invalid @enderror" required>
        <option value="" disabled {{ old('roles') ? '' : 'selected' }}>Select Role</option>
        @foreach ($roles as $role)
        <option value="{{ $role->name }}" @if (is_array(old('roles')) && in_array($role->name, old('roles')))
            selected
            @elseif(isset($user) && $user->roles && in_array($role->name, $user->roles->pluck('name')->toArray()))
            selected
            @endif>
            {{ $role->name }}
        </option>
        @endforeach
    </select>
    @error('roles')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


