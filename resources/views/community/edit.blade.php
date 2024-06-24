@extends('base')
@section('title', 'update community Member')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('community.update', ['community' => $community->id]) }}" method="POST">
                @method('PATCH')
                @csrf
                @include('community.fields')

                <div class="form-group">
                    <input type="submit" value="Update Community member" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
