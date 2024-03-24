<div class="form-group">
    <label for="">Full Name</label>
    <input type="text" name="full_name" value="{{ old('full_name') ?? $user?->full_name }}" id="full_name" class="form-control" placeholder="Full Name">
    @error('full_name')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="">Email</label>
    <input type="text" name="email" value="{{ old('email') ?? $user?->email }}" id="email" class="form-control" placeholder="Full Name">
    @error('email')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {{-- @dd($user->roles) --}}

    <label for="gender">Role</label>
    <select name="roles[]" id="roles" class=" @error('roles') is-invalid @enderror form-control  form-control select2" required>
        <option value="" disabled selected> </option>
        @foreach ($roles as $role )
        <option value="{{$role->name}}" {{$user->roles}}>{{$role->name}}</option>
        @endforeach
    </select>
    @error('roles')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
