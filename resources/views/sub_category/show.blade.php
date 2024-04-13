@extends('base')
@section('title', 'Approver on the sub')
@push('js')
<script>
    function deleteItem(route, parent, user_id, sub_category_id) {

        event.preventDefault();
        Swal.fire({
            title: "Are you sure to remove the Approver?"
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
                        'user_id': user_id
                        , 'sub_category_id': sub_category_id

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
                            console.log(data);
                            Swal.fire("Forbidden!", "You can't delete this", "error");
                        }
                    }
                });
            }
        });
    }

    function openEditModal(id, name, categoryId, description, route) {
        $('#editCategoryModal #edit_id').val(id);
        $('#editCategoryModal #edit_name').val(name);
        $('#editCategoryModal #edit_category').val(categoryId);
        $('#editCategoryModal #edit_description').val(description);
        $('#editCategoryModal #editCategoryForm').attr('action', route);
        $('#editCategoryModal').modal('show');

    }
    $(document).ready(function() {
        $('#editForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var categoryId = $('#edit_id').val(); // Retrieve category ID
            $.ajax({
                type: "PUT"
                , url: "{{ url('category') }}" + '/' + categoryId, // Include category ID in URL
                data: formData
                , dataType: 'json'
                , success: function(response) {
                    $('#editModal').modal('hide');
                    // Handle success, maybe update table row or reload page
                }
                , error: function(error) {
                    console.log(error);
                    // Handle error
                }
            });
        });
    });

</script>
@endpush
@section('content')
@include('sub_category.assign_approver_modal')

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
                <span>Total: {{ count($approvers) }}</span>
                Approvers
                <span class="d-block text-muted pt-2 font-size-sm">All Approvers</span>

                <div class="">
                </div>
            </h3>
        </div>
        <div class="card-tools">
            {{-- <a href="{{ route('sub_category.create', []) }}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Add
            Sub
            Category</a> --}}

            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus mr-2"></i>Add sub Category
                Approver</button>
        </div>
    </div>
    <div class="card-body">
        <!--begin: Datatable-->
        <div class="datatable datatable-default datatable-bordered datatable-loaded">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th> Actions</th>
                    </tr>
                </thead>
                <tbody style="" class="datatable-body">

                    @foreach ($approvers as $key => $approver)

                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $approver?->full_name }}</td>

                        <td class="d-flex justify-content-around">

                            <a href="#" onclick="event.preventDefault();deleteItem('{{ route('sub_category.unassign_approver') }}',$(this))" class="">
                                <i class="fa fa-trash text-danger"></i>
                            </a>

                        </td>
                    </tr>
                    @endforeach

                    @if (count($approvers) < 1) <tr>

                        <td class="text-capitalize text-danger text-center font-size-h4" colspan="5">No Record
                            Found</td>
                        </tr>
                        @endif
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
