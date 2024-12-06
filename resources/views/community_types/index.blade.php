@extends('base')
@section('title', ' Comminity Types')

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
                        $(parent).closest('tr').remove();
                        Swal.fire(
                            "Deleted!"
                            , "Item has been deleted."
                            , "success"
                        )
                    }
                    , error: function(data) {
                        if (data.status) {
                            Swal.fire(data.statusText + "", data.responseJson + ' ', "error");
                        }
                    }
                });
            }
        });
    }

    function openEditModal(id, name, route) {
        $('#editRegionModal #edit_id').val(id);
        $('#editRegionModal #edit_name').val(name);
        $('#editRegionModal #edit_description').val(description);
        $('#editRegionModal #editRegionForm').attr('action', route);
        $('#editRegionModal').modal('show');

    }

    $(document).ready(function() {
        $('#editForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var RegionId = $('#edit_id').val(); // Retrieve Region ID
            $.ajax({
                type: "PUT"
                , url: "{{ url('community-type') }}" + '/' + RegionId, // Include Region ID in URL

                data: formData
                , dataType: 'json'
                , success: function(response) {
                    $('#editModal').modal('hide');
                    // Handle success, maybe update table row or reload page
                }
                , error: function(error) {
                    // Handle error
                }
            });
        });
    });

</script>
@endpush

@section('content')
@include('community_types.modal')
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
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                <span>Total: {{ $items->total() }}</span>
                commuity Type
                <span class="d-block text-muted pt-2 font-size-sm">All Commuity Types</span>
                <div class="">
                </div>
            </h3>
        </div>
        <div class="card-tools">
            <button type="button" class="btn btn-primary mb-3 my-2" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus mr-2 my-2"></i>Add
                Community Type</button>

        </div>
    </div>
    <!-- Rest of your content -->
    <div class="card-body">
        <!--begin: Datatable-->
        <div class="datatable datatable-default datatable-bordered datatable-loaded">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th> Name</th>
                        <th> Actions</th>
                    </tr>
                </thead>
                <tbody style="" class="datatable-body">
                    @foreach ($items as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="d-flex justify-content-around">
                            <a href="#" onclick="openEditModal('{{ $item->id }}', '{{ $item->name }}','{{ route('community-type.update',['community_type'=>$item->id]) }}')">
                                <i class="fa fa-pen"></i>
                            </a>
                            <a href="#" onclick="deleteItem('{{ route('community-type.destroy', ['community_type' => $item->id]) }}', $(this))">
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
