@extends('base')
@section('title', 'Schema Management')
@push('js')
    <script>
        function deleteItem(route, parent) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure to delete?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: route,
                        data: {
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Item has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this", "error");
                            }
                        }
                    });
                }
            });
        }

        function openEditModal(id, name, forceValidation, subCategoryId, route) {
            $('#editCategoryModal #edit_id').val(id);
            $('#editCategoryModal #edit_name').val(name);
            $('#editCategoryModal #forceValidation').prop('checked', forceValidation == 1 ? true : false);
            $('#editCategoryModal #edit_sub_category').val(subCategoryId);
            $('#editCategoryModal #editCategoryForm').attr('action', route);
            $('#editCategoryModal').modal('show');

        }

        $(document).ready(function() {
            $('#editForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                var categoryId = $('#edit_id').val(); // Retrieve category ID
                $.ajax({
                    type: "PUT",
                    url: "{{ url('category') }}" + '/' + categoryId, // Include category ID in URL
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        $('#editModal').modal('hide');
                        // Handle success, maybe update table row or reload page
                    },
                    error: function(error) {
                        console.log(error);
                        // Handle error
                    }
                });
            });
        });
    </script>
@endpush
@section('content')
    <div class="card card-custom">
        @include('data_schema.modal')

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
                    data categories
                    <span class="d-block text-muted pt-2 font-size-sm">All data schema</span>
                    <div class="">
                    </div>
                </h3>
            </div>
            <div class="card-tools">
                <a href="#" data-toggle="modal" data-target="#addModal" class="btn btn-primary"><i
                        class="fa fa-plus mr-2"></i>Add
                    data schema</a>
            </div>
        </div>
        <div class="card-body">
            <div class="datatable datatable-default datatable-bordered datatable-loaded">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Schema Name</th>
                            <th>Sub Category Name</th>
                            <th>Force Validation</th>
                            <th> Actions</th>
                        </tr>
                    </thead>
                    <tbody style="" class="datatable-body">
                        <tr>
                            <td>1</td>
                            <td>Core Group Data</td>
                            <td>Core group data</td>
                            <td><span class="badge badge-info badge-sm">{{ true ? 'True' : 'False' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('core-group-data.index') }}" class="">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>AFP - EPHI Data</td>
                            <td>AFP - EPHI Data</td>
                            <td><span class="badge badge-info badge-sm">{{ true ? 'True' : 'False' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('afp-data.index') }}" class="">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @foreach ($items as $key => $item)
                            <tr>
                                <td>{{ $key + 3 }}</td>
                                <td>{{ $item?->name }}</td>
                                <td>{{ $item?->subCategory?->name }}</td>
                                <td><span
                                        class="badge badge-info badge-sm">{{ $item?->force_validation ? 'True' : 'False' }}</span>
                                </td>
                                <td class="d-flex justify-content-around">
                                    <a href="{{ route('data_schema.show', ['data_schema' => $item->id]) }}" class="">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="#"
                                        onclick="openEditModal('{{ $item->id }}', '{{ $item->name }}','{{ $item->force_validation }}',{{ $item->sub_category_id }},'{{ route('data_schema.update', ['data_schema' => $item->id]) }}')"
                                        class="">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="#"
                                        onclick="event.preventDefault();deleteItem('{{ route('data_schema.destroy', ['data_schema' => $item->id]) }}',$(this))"
                                        class="">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        @if (count($items) < 1)
                            <tr>
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
