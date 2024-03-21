@extends('base')
@section('title', 'Create a new data category')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('category.update', ['category' => $category->id]) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    @include('category.fields')
                    <div class="form-group">
                        <input type="submit" value="Update Category"
                            class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
