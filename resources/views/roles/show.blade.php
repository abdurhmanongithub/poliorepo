@extends('base')
@section('title', 'Show a Role')


@section('content')

    <form action="{{ route('role.giveAllPermission', ['role' => $role->id]) }}"
        id="formGiveAllPermission" method="post">
        @csrf
    </form>
    <form action="{{ route('role.removeAllPermission', ['role' => $role->id]) }}"
        id="formRevokeAllPermission" method="post">
        @csrf
    </form>
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">All roles
                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                </h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <!--begin: Search Form-->
            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="row align-items-center">
                            <form
                                action="{{ route('role.permission.give', ['role' => $role->id]) }}"
                                class="col-12 row" method="POST">
                                <div class="col-md-10">
                                    <div class="row align-items-center">
                                        <div class="col-md-12 my-2 my-md-0">
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <select
                                                        class="form-control select2 @error('permission') is-invalid @enderror"
                                                        id="select_permission" multiple
                                                        name="permissions[]">
                                                        <option value=""></option>
                                                        @foreach ($freePermissions as $permission)
                                                            <option
                                                                value="{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('permission')
                                                        <div class="fv-plugins-message-container">
                                                            <div data-field="permission"
                                                                data-validator="stringLength"
                                                                class="fv-help-block">
                                                                {{ $message }}</div>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @csrf
                                <div class="col-md-2 mt-5 mt-lg-0">
                                    <input type="submit"
                                        class="btn btn-light-primary px-6 font-weight-bold"
                                        value="Assign Permission">
                                </div>
                            </form>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary px-6 font-weight-bold"
                                onclick="giveAllPermission();">Give All
                                Permission</button>
                            <button class="btn btn-danger px-6 font-weight-bold"
                                onclick="revokeAllPermission();">Remove All
                                Permission</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Search Form-->
            <!--end: Search Form-->
            <!--begin: Datatable-->
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable">
            </div>
            <!--end: Datatable-->
        </div>
    </div>
    <!--end::Card-->

@endsection
@push('js')
<script>
    var HOST_URL = "{{ route('role.permission.index', ['role' => $role->id]) }}";

</script>




    <script>
        $(function() {
            $('#select_permission').select2({
                placeholder: "Select a permission"
            });
        });

        function revokeAllPermission() {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, revoke all permission!"
            }).then(function(result) {
                if (result.value) {
                    $('#formRevokeAllPermission').submit();
                }
            });
        }

        function giveAllPermission() {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, give all permission!"
            }).then(function(result) {
                if (result.value) {
                    $('#formGiveAllPermission').submit();
                }
            });
        }

        function deleteRole(permissionId, parent) {
            event.preventDefault();
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '/role/' + {{
                                $role -> id
                            }} + '/permission/' + permissionId,
                        data: {
                            "id": permissionId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr(
                                'content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            swal.fire(
                                "Deleted!", "Role has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                swal.fire("Forbidden!",
                                    "You can't delete this role!",
                                    "error");
                            }
                        }
                    });
                }
            });
        }
        var COLUMNS = [{
            field: 'id',
            title: '#',
            sortable: 'asc',
            width: 30,
            type: 'number',
            selector: false,
            textAlign: 'center',
            template: function(row, index) {
                return index + 1;
            }
        }, {
            field: 'name',
            title: 'Name',
            sortable: 'asc',
        }, {
            field: 'Actions',
            title: 'Actions',
            sortable: false,
            width: 100,
            overflow: 'visible',
            autoHide: false,
            template: function(row) {
                var permissionId = row.id;
                return '\
                                <div class="d-flex">\
                                <a href="javascript:;" onclick="deleteRole(' +
                    permissionId + ',$(this))" class="btn btn-sm btn-clean btn-icon" >\
                                <i class="far fa-trash"></i>\
                                </a>\
                                \
                                </div>\
                                ';
            },
        }];
    </script>
    <script>
        var HOST_URL = "{{ route('role.permission.index', ['role' => $role->id]) }}";

    </script>




    <script src="{{ asset('assets/data-ajax.js') }}"></script>
@endpush
