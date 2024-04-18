@extends('base')
@section('title', 'Create a new data category')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('sub_category.store') }}" method="POST">
                @csrf
                @include('knowledge_types.fields')
                <div class="form-group">
                    <input type="submit" value="Save Sub-Category" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
