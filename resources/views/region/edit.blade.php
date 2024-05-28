@extends('base')
@section('title', 'Edit Region')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('region.update', ['region' => $region->id]) }}" method="POST">
                @method('PATCH')
                @csrf
                @include('region.fields')
                <div class="form-group">
                    <input type="submit" value="Update Category" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
