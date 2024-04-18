@extends('base')
@section('title', 'Edit sub category')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('sub_category.update', ['sub_category' => $subCategory->id]) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    @include('sub_category.fields')
                    <div class="form-group">
                        <input type="submit" value="Update Category"
                            class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
