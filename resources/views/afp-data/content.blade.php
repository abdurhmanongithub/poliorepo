@extends('afp-data.sublayout')
@section('title', 'Source Page')
@push('js')
    <script>
        $(document).ready(function() {
            const csrf = $('meta[name="csrf-token"]').attr('content');

            // Open Modal for Add
            $('#addContentBtn').click(function() {
                $('#contentForm')[0].reset();
                $('#contentId').val('');
                $('#contentModalLabel').text('Add Content');
                $('#contentModal').modal('show');
            });

            // Edit Button
            $('.editBtn').click(function() {
                const row = $(this).closest('tr');
                $('#contentId').val(row.data('id'));
                $('#title').val(row.find('td:eq(1)').text());
                $('#language').val(row.find('td:eq(2)').text());
                $('#content').val(row.find('td:eq(3)').text());
                $('#contentModalLabel').text('Edit Content');
                $('#contentModal').modal('show');
            });

            // Submit Form
            $('#contentForm').submit(function(e) {
                e.preventDefault();
                const id = $('#contentId').val();
                const url = id ? `/a-f-p-data/knowledge/${id}` : '/a-f-p-data/knowledge';
                const method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    data: {
                        title: $('#title').val(),
                        content: $('#content').val(),
                        language: $('#language').val(),
                    },
                    success: function() {
                        location.reload();
                    }
                });
            });

            // Delete Button
            $('.deleteBtn').click(function() {
                const id = $(this).closest('tr').data('id');
                if (confirm('Are you sure you want to delete this content?')) {
                    $.ajax({
                        url: `/a-f-p-data/knowledge/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        success: function() {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush

@section('nav_content')
    <form action="" method="POST" id="deleteSourceForm">
        <input type="hidden" name="source" id="dataSourceValue">
        @csrf
    </form>
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title align-items-start flex-column">
                <h3 class="card-label font-weight-bolder text-dark">Knowledge Management</h3>
            </div>
            <button class="btn btn-success mb-3" id="addContentBtn">Add Content</button>

        </div>
        <div class="card-body">
            <table class="table rounded table-bordered">
                <tr>
                    <td>ID</td>
                    <td>Title</td>
                    <td>Language</td>
                    <td>Content</td>
                    <td>Action</td>
                </tr>
                @foreach ($contents as $content)
                    <tr data-id="{{ $content->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $content->title }}</td>
                        <td>{{ $content->language }}</td>
                        <td>{{ $content->content }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm editBtn">Edit</button>
                            <button class="btn btn-danger btn-sm deleteBtn">Delete</button>
                        </td>
                    </tr>
                @endforeach
                @if ($contents->count() == 0)
                    <td class="text-capitalize text-danger text-center font-size-h4" colspan="4">No Record
                        Found
                    </td>
                @endif
            </table>
        </div>
    </div>




    <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="contentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contentModalLabel">Add Content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="contentForm">
                    <div class="modal-body">
                        <input type="hidden" id="contentId">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label>Content</label>
                            <textarea class="form-control" id="content" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Language</label>
                            <input type="text" class="form-control" id="language" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
