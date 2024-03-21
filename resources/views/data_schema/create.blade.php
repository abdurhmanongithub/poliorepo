@extends('base')
@section('title', 'Create a new data schema')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('data_schema.store') }}" method="POST">
                    @csrf
                    @include('data_schema.fields')
                    <div class="form-group">
                        <input type="submit" value="Save Data Schema" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
