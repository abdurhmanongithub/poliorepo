@extends('base')
@section('title', 'Create a new data category')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                    @include('category.fields')
                    <div class="form-group">
                        <input type="submit" value="Save Category" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
