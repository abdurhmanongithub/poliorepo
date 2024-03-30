<div class="form-group row">
    <label class="col-lg-12 col-form-label">Attribute Management:</label>
    <div data-repeater-list="attribute" class="col-lg-12">
        @foreach ($dataSchema?->getListOfAttributes() as $key => $attribute)
            <div data-repeater-item="" class="form-group row align-items-center">
                <div class="col-md-4">
                    <label>Attribute Name</label>
                    <input type="text" required value="{{ $attribute['name'] }}"
                        name="attribute[{{ $key }}][name]" class="form-control"
                        placeholder="Enter attrubte name" />
                    <div class="d-md-none mb-2"></div>
                </div>
                <div class="col-md-4">
                    <label>Attribute Type</label>
                    <select required name="attribute[{{ $key }}][type]" class="form-control" id="">
                        @foreach (\App\Constants::ATTRIBUTE_TYPES as $constant)
                            <option {{ $attribute['type'] == $constant ? 'selected' : '' }} value="{{ $constant }}">
                                {{ ucfirst($constant) }}</option>
                        @endforeach
                    </select>
                    <div class="d-md-none mb-2"></div>
                </div>
                <div class="col-md-2">
                    <div class="checkbox-list">
                        <label class="checkbox mt-4"
                            title="If checked, any validation error will terminate import process!">
                            <input {{ $attribute['is_required'] ? 'checked' : '' }}
                                name="attribute[{{ $key }}][is_required]" type="checkbox">
                            <span class="ml-3"></span>
                            Is required
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href="javascript:;" data-repeater-delete=""
                        class="btn btn-sm font-weight-bolder btn-light-danger">
                        <i class="la la-trash-o"></i>Delete</a>
                </div>
            </div>
        @endforeach
        @if (count($dataSchema->getListOfAttributes()) == 0)
            <div data-repeater-item="" class="form-group row align-items-center">
                <div class="col-md-4">
                    <label>Attribute Name</label>
                    <input type="text" required name="attribute[0][name]" class="form-control"
                        placeholder="Enter attrubte name" />
                    <div class="d-md-none mb-2"></div>
                </div>
                <div class="col-md-4">
                    <label>Attribute Type</label>
                    <select required name="attribute[0][type]" class="form-control" id="">
                        @foreach (\App\Constants::ATTRIBUTE_TYPES as $constant)
                            <option value="{{ $constant }}">{{ ucfirst($constant) }}</option>
                        @endforeach
                    </select>
                    <div class="d-md-none mb-2"></div>
                </div>
                <div class="col-md-2">
                    <div class="checkbox-list">
                        <label class="checkbox mt-4"
                            title="If checked, any validation error will terminate import process!">
                            <input name="attribute[0][is_required]" type="checkbox">
                            <span class="ml-3"></span>
                            Is required
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href="javascript:;" data-repeater-delete=""
                        class="btn btn-sm font-weight-bolder btn-light-danger">
                        <i class="la la-trash-o"></i>Delete</a>
                </div>
            </div>
        @endif
    </div>
</div>
