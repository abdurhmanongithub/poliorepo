@extends('base')
@section('title', 'Create a Role')


@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                @include('roles.fields')
                <div class="form-group">
                    <input type="submit" value="Save role" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

