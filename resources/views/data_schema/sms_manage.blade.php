@extends('layouts.sublayout')
@section('nav_content')
<div class="card card-custom">
    <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">Sms Manage</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">{{ $dataSchema->name }}</span>
        </div>
        <div class="col-12">
            <form action="{{ route('sms-history.store') }}" method="POST">
                <input type="hidden" name="sms_type" value="{{ App\Constants::INFORMATION}}">
                <input type="hidden" name="data_schema_id" value="{{$dataSchema->id}}">




                @csrf
                <div class="row">
                    <div class="form-group">
                        <label>Send for</label>
                        <div>
                            <label>
                                <input type="radio" name="type" value="individual" onclick="toggleSelect()" {{ old('type') == 'individual' ? 'checked' : '' }}> Individual
                            </label>
                            <label>
                                <input type="radio" name="type" value="all" onclick="toggleSelect()" {{ old('type') == 'all' ? 'checked' : '' }}> All
                            </label>
                        </div>
                    </div>

                    <div id="sub-category-group" class="form-group col-4" style="display: none;">
                        <label for="community_id">Community members</label>
                        <select name="community_ids[]" class="form-control" multiple id="community_id">
                            <option value="" disabled selected multiple>Select</option>
                            @foreach ($dataSchema->subCategory->communities as $com)
                            <option value="{{ $com->id }}">
                                {{ $com->full_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div id="sub-knowlede-group" class="form-group col-6">
                        <label for="community_id">Knowledges</label>
                        <select name="knowledge_ids[]" class="form-control select2" multiple id="knowlede_id" required>

                            <option value="" disabled>Select</option>
                            @foreach ($dataSchema->subCategory->knowledges as $know)
                            <option value="{{ $know->id }}">
                                {{ $know->message }}
                            </option>
                            @endforeach
                        </select>

                    </div>


                </div>

                <button type="submit" class="btn btn-primary" onclick="return confirm">send</button>
            </form>

        </div>
        <div class="card-toolbar">


        </div>
    </div>
    <div class="card-body">
        <div class="card-body">
            <div class="datatable datatable-default datatable-bordered datatable-loaded">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Full Name</th>
                            <th>Phone</th>
                            <th>Knowlwdge</th>
                            <th>Date</th>

                        </tr>
                    </thead>
                    <tbody style="" class="datatable-body">
                        @foreach ($smsHistories as $key => $his)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $his?->community?->full_name }}</td>
                            <td>{{ $his->community?->phone }}</td>


                            @php
                            $message = $his->knowledge?->message;
                            @endphp

                            @if(strlen($message) >= 100)
                            <td>
                                <details>
                                    <summary>{{substr($message, 0, 100) .'....'}}</summary>

                                    {{ $message }}
                                </details>
                            </td>
                            @else
                            <td>{{ $message }}</td>
                            @endif


                            <td>{{ $his->created_at }}</td>



                        </tr>
                        @endforeach
                        @if (count($dataSchema->subCategory->communities) < 1) <tr>

                            <td class="text-capitalize text-danger text-center font-size-h4" colspan="5">No Record
                                Found</td>
                            </tr>
                            @endif
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>
@endsection
@push('js')
<script>
    function toggleSelect() {
        const individualRadio = document.querySelector('input[name="type"][value="individual"]');
        const subCategoryGroup = document.getElementById('sub-category-group');
        if (individualRadio.checked) {
            subCategoryGroup.style.display = 'block';
        } else {
            subCategoryGroup.style.display = 'none';
        }
    }

    // Ensure the correct state is set when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        toggleSelect();
    });

</script>

@endpush
