@extends('base')
@section('title', 'Import Weather')
@section('content')
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

<div class="modal fade" id="modal-import">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('phonenumber_import') }}" id="file-upload" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import The Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="col-sm-5 control-label no-padding-right">Select File: </label>
                            <input type="file" class="form-control" name="file" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-sm-5 control-label no-padding-right">Select File: </label>
                            <input type="text" class="form-control" name="Location" required>
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Import</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<form action="{{ route('sms.custom.store') }}" method="post">

    @csrf
    @if (Session::has('errors'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ Session::get('errors') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            {{-- <span aria-hidden="true">&times;</span> --}}
        </button>
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-default" href="#" data-toggle="modal" data-target="#modal-import">
                    <i class="fas fa-file-import"></i> Import Phone Number
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label class="col-sm-5 control-label no-padding-right">Phone Number</label>
                    <textarea name="receiver_phone" id="receiver_phone" cols="5" rows="10" class="form-control" required></textarea>
                    <small class="font-bold">Please Use Phone Number Which Start With 09 Or +251</small>
                    <small class="font-bold">for Sending multiple sms Messages separate the Phone Numbers Using ,
                        eg. 0911111111,0922222222
                    </small>

                </div>

                <div class="form-group col-sm-6">
                    <label class="col-sm-5 control-label no-padding-right">Messages</label>
                    <textarea name="message" id="" cols="30" rows="10" class="form-control" required></textarea>
                </div>
            </div>

            <button class="btn btn-success float-right" type="submit" onclick="confirm('Are you sure to take this action?');">Send</button>

        </div>
    </div>
</form>

@endsection
@push('js')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#file-upload').submit(function(e) {
        e.preventDefault();
        $('#modal-import').modal('toggle');
        let formData = new FormData(this);
        $('#file-input-error').text('');

        $.ajax({
            type: 'POST'
            , url: "{{ route('phonenumber_import') }}"
            , data: formData
            , contentType: false
            , processData: false
            , success: (response) => {
                if (response) {
                    $("#receiver_phone").val(response.req)
                    this.reset();
                }
            }
            , error: function(response) {
                $('#file-input-error').text(response.responseJSON.message);
            }
        });
    });

</script>
<script>
    // Get the select and textarea elements
    const selectElement = document.getElementById('selectElement');
    const textAreaElement = document.getElementById('textAreaElement');

    // Disable the textarea when option 2 is selected
    selectElement.addEventListener('change', (event) => {
        if (event.target.value === 'empty') {

            textAreaElement.disabled = false;
        } else {

            textAreaElement.disabled = true;
            textAreaElement.style.display = 'none';
        }
    });
    textAreaElement.addEventListener('input', (event) => {
        if (event.target.value !== '') {
            for (const option of selectElement.options) {
                option.disabled = true;
            }
        } else {
            for (const option of selectElement.options) {
                option.disabled = false;
            }
        }
    });

</script>

@endpush
