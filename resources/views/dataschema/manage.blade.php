@extends('layouts.sublayout')
@section('nav_content')
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title align-items-start flex-column">
                <h3 class="card-label font-weight-bolder text-dark">Schema Management</h3>
                <span class="text-muted font-weight-bold font-size-sm mt-1">{{ count($dataSchema->getListOfAttributes()) }}
                    Attributes Available</span>
            </div>
            <div class="card-toolbar">
                <button type="reset" class="btn btn-success mr-2">Export Report</button>
            </div>
        </div>
        <div class="card-body">
            <div id="kt_repeater_11">
                <form action="{{ route('data_schema.attribute.add', ['data_schema' => $dataSchema->id]) }}" method="POST">
                    @csrf
                    @include('data_schema.attribute_manager')
                    <div class="form-group row">
                        <a href="javascript:;" data-repeater-create=""
                            class="btn btn-sm font-weight-bolder btn-light-primary">
                            <i class="la la-plus"></i>Add Attribute</a>
                    </div>
                    <div class="form-group row">
                        <input type="submit" value="Save" class="btn btn-sm font-weight-bolder btn-light-primary">
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <script>
        var KTFormRepeater = function() {

            // Private functions
            var demo1 = function() {
                $('#kt_repeater_11').repeater({
                    initEmpty: false,
                    defaultValues: {},

                    hide: function(remove) {
                        Swal.fire({
                            title: "Are you sure to remove?",
                            text: "You won't be able to revert this!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes, Delete it!"
                        }).then(function(result) {
                            if (result.value) {
                                $(this).slideUp(remove);

                            }
                        });
                    }
                });
            }
            return {
                // public functions
                init: function() {
                    demo1();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTFormRepeater.init();
        });
    </script>
@endsection
