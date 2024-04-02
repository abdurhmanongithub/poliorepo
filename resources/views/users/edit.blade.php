@extends('base')
@section('title', 'Create a new data category')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                @method('PATCH')
                @csrf
                @include('users.fields')
                <div class="form-group">
                    <input type="submit" value="Update Category" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#roles').select2({

            placeholder: "Select a Role"
        });


    });

</script>

@endpush
