@extends('base')
@section('title', 'Create new community')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('community.store') }}" method="POST">
                    @csrf
                    @include('community.fields')
                    <div class="form-group">
                        <input type="submit" value="Save community" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
