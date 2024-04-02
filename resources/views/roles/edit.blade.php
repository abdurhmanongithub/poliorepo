@extends('base')
@section('title', 'Create a new data category')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="POST">
                @method('PATCH')
                @csrf
                @include('roles.fields')
                <div class="form-group">
                    <input type="submit" value="Update role" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
