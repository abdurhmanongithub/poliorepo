@extends('afp-data.sublayout')
@section('title', 'Source Page')
@push('js')
    <script>
        var card = new KTCard('kt_card_1');
        $(document).ready(function() {
            function toggleFields() {
                var selectedValue = $('#sendBy').val();
                $('#communityTypeDiv').hide();
                $('#communityDiv').hide();
                $('#csvDiv').hide();
                if (selectedValue == '0') {
                    $('#communityTypeDiv').show();
                } else if (selectedValue == '1') {
                    $('#communityDiv').show();
                } else if (selectedValue == '2') {
                    $('#csvDiv').show();
                }
            }
            toggleFields();
            $('#sendBy').change(function() {
                toggleFields();
            });
        });
        $(function() {
            var input = document.getElementById('csv');
            tagify = new Tagify(input);
        })
    </script>
@endpush
@section('nav_content')
    <div class="card card-custom card-collapsedd mb-2" data-card="true" id="kt_card_1">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Broadcast Knowledge </h3>
            </div>
            <div class="card-toolbar">
                <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-1" data-card-tool="toggle">
                    <i class="ki ki-arrow-down icon-xs"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('afp-data.notify', ['content' => $content->id]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="sendBy">Send By</label>
                        <select name="send_by" id="sendBy" class="w-100 select2">
                            <option value="0" selected>Community Type</option>
                            <option value="1">Individual</option>
                            <option value="2">CSV</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6" id="communityTypeDiv">
                        <label for="communityType">Community Type</label>
                        <select name="community_type" id="communityType" class="w-100 select2">
                            <option value="">Select Option</option>
                            @foreach ($communityTypes as $communityType)
                                <option value="{{ $communityType->id }}">{{ $communityType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6" id="communityDiv">
                        <label for="communityMembers">Community Members/Community</label>
                        <select multiple name="communities[]" id="communityMembers" class="w-100 select2">
                            <option value="">Select Option</option>
                            @foreach ($communities as $community)
                                <option value="{{ $community->id }}">{{ $community->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6" id="csvDiv">
                        <label for="csv">Community Members/CSV</label>
                        <input id="csv" class="form-control tagify" name='csv' placeholder='Phone Numbers' />

                        {{-- <textarea name="csv" id="csv" class="form-control"></textarea> --}}
                    </div>
                </div>
                <input type="submit" value="Broadcast" class="btn btn-primary">
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="">
                Knowledge Management
            </h5>
        </div>
        <div class="card-body">
            <div>
                <table class="table table-bordered">
                    <tr>
                        <td>Name</td>
                        <td>Phone</td>
                        <td>Community Type</td>
                        <td>SMS Status</td>
                    </tr>
                    @foreach ($notifications as $notification)
                        <tr>
                            <td>{{ $notification?->community?->full_name }}</td>
                            <td>{{ $notification?->phone }}</td>
                            <td>{{ $notification?->community?->communityType?->name }}</td>
                            <td>{!! $notification->getStatus() !!}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    @if ($notifications->count() == 0)
                        <tr>
                            <td colspan="56">No data found</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection
