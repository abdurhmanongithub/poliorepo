@extends('base')
@push('js')
    <script>
        $('#columnSelector').on('change', function() {
            const selectedOptions = $(this).val();

            $('#dataTable th, #dataTable td').addClass('d-none');

            selectedOptions.forEach(option => {
                console.log(option);
                $(`#dataTable .field-${option}`).removeClass('d-none');
            });
        });
    </script>
@endpush
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon2-supermarket text-primary"></i>
                </span>
                <h3 class="card-label">{{ ucwords(str_replace('_', ' ', $table)) . ' Table' }}</h3>
            </div>
            <div class="card-toolbar">
                <div class="form-group">
                    <label for="columnSelector">Select Columns</label>
                    <select id="columnSelector" multiple>
                        @foreach ($fields as $field)
                            <option {{ $field->selected ? 'selected' : '' }} value="{{ $field->name }}">
                                {{ ucwords(str_replace('_', ' ', $field->name)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            @include('polio.filter')
            <table class="table table-sm table-bordered table-hover table-checkable" id="datatable"
                style="margin-top: 13px !important">
                <thead>
                    <tr>
                        @foreach ($fields as $field)
                            <td class="field-{{ $field->name }} {{ $field->selected ? '' : 'd-none' }} ">
                                {{ ucwords(str_replace('_', ' ', $field->name)) }}
                            </td>
                        @endforeach
                    </tr>

                    @foreach ($rows as $row)
                        <tr>
                            @foreach ($fields as $field)
                                @php
                                    $name = $field->name;
                                @endphp
                                <td class="field-{{ $field->name }} {{ $field->selected ? '' : 'd-none' }}">
                                    {{ $row->$name }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </thead>
            </table>
        </div>
        <div class="card-footer">
            <div class="">{{ $rows->links() }}</div>
        </div>
    </div>
@endsection
