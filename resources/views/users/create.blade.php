@extends('base')
@section('title', 'Role Create')
@push('css')
<style>
    .select2,
    .select2-container,
    .select2-container--default,
    .select2-container--below {
        width: 100% !important;
    }

</style>
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                @include('users.fields')
                <div class="form-group">
                    <input type="submit" value="Save User" class="btn btn-primary">
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
