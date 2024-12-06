@extends('base')
@section('title', 'User')
@push('js')
<script>
    function deleteItem(route, parent) {
        event.preventDefault();
        Swal.fire({
            title: "Are you sure to delete?"
            , text: "You won't be able to revert this!"
            , type: "warning"
            , showCancelButton: true
            , confirmButtonText: "Yes, Delete it!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST"
                    , url: route
                    , data: {
                        "_method": 'DELETE'
                        , "_token": $('meta[name="csrf-token"]').attr('content')
                    , }
                    , dataType: 'json'
                    , success: function(data) {
                        $(parent).closest('tr')[0].remove();
                        Swal.fire(
                            "Deleted!"
                            , "Item has been deleted."
                            , "success"
                        )
                    }
                    , error: function(data) {

                        if (data.status) {
                            Swal.fire("Forbidden!", "You can't delete this", "error");
                        }
                    }
                });
            }
        });
    }

</script>
@endpush
@section('content')
<div class="card card-custom">
    @if ($errors->any())
    <div class="alert alert-danger">
        <p><strong>Oops Something went wrong</strong></p>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">
                <span>Total: {{ $items->total() }}</span>
                users
                <span class="d-block text-muted pt-2 font-size-sm">All users</span>
                <div class="">
                </div>
            </h3>
        </div>
        <div class="card-tools">
            <a href="{{ route('users.create', []) }}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Add user</a>
        </div>
    </div>
    <div class="card-body">
        <!--begin: Datatable-->
        <div class="datatable datatable-default datatable-bordered datatable-loaded">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>

                        <th>Roles</th>
                        <th> Actions</th>
                    </tr>
                </thead>
                <tbody style="" class="datatable-body">
                    @foreach ($items as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ $item->email}}</td>
                        <td>{{ $item->phone}}</td>

                        <td>
                            @foreach ($item->roles as $role )

                            <li class="badge badge-info badge-pill">{{$role->name}}</li>

                            @endforeach
                        </td>

                        <td class="d-flex justify-content-around">
                            <a href="{{ route('users.edit', ['user' => $item->id]) }}" class="">
                                <i class="fa fa-pen"></i>
                            </a>
                            <a href="#" onclick="event.preventDefault();deleteItem('{{ route('users.destroy', ['user' => $item->id]) }}',$(this))" class="">
                                <i class="fa fa-trash text-danger"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @if (count($items) < 1) <tr>
                        <td class="text-capitalize text-danger text-center font-size-h4" colspan="4">No Record
                            Found</td>
                        </tr>
                        @endif
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
