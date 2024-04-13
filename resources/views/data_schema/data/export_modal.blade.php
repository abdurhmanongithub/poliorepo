<div class="modal fade" id="exportDataModal" tabindex="-1" role="dialog" aria-labelledby="exportDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportDataModalLabel">Export Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="{{ route('data_schema.data.export', ['data_schema' => $dataSchema->id]) }}"
                        id="exportForm" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label for="dataFormat">Data Format</label>
                                <select name="type" class="select2 w-100 d-block" id="dataFormat">
                                    @foreach (\App\Constants::EXPORT_TYPES as $key => $exportType)
                                        <option value="{{ $key }}">{{ $exportType }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="sourceSelect">Select Batch</label>
                                <select name="batch" class="select2 w-100 d-block" id="sourceSelect">
                                    <option value="all">ALL</option>
                                    @foreach ($dataSchema->getDataBatch() as $item)
                                        <option value="{{ $item }}">@uppercase($item)</option>
                                    @endforeach
                                </select>

                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="$('#exportForm').submit()" class="btn btn-primary"
                    data-dismiss="modal">Export Data</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
