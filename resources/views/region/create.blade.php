@extends('base')
@section('title', 'Create a new Region')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('region.store') }}" method="POST">
                    @csrf
                    @include('region.fields')
                    <div class="form-group">
                        <input type="submit" value="Save Region" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
