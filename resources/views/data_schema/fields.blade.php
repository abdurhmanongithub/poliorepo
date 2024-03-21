<div class="row">
    <div class="form-group col-md-6">
        <label for="">Sub Category Name</label>
        <input type="text" name="name" value="{{ old('name') ?? $dataSchema?->name }}" id="name"
            class="form-control" placeholder="Sub Category Name">
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="">Sub Categories</label>
        <select name="category_id" class="form-control " id="category_id">
            <option value="">Select Subcategory</option>
            @foreach ($subCategories as $subCategory)
                <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
            @endforeach
        </select>
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
<div id="kt_repeater_1">
    <div class="form-group row">
        <label class="col-lg-12 col-form-label">Attribute Management:</label>
        <div data-repeater-list="" class="col-lg-12">
            <div data-repeater-item="" class="form-group row align-items-center">
                <div class="col-md-4">
                    <label>Attribute Name</label>
                    <input type="email" class="form-control" placeholder="Enter full name" />
                    <div class="d-md-none mb-2"></div>
                </div>
                <div class="col-md-4">
                    <label>Attribute Type</label>
                    <select name="attribute[]" class="form-control" id="">
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
                            <input type="checkbox">
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
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-4">
            <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                <i class="la la-plus"></i>Add Attribute</a>
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-9 col-xl-6">
        <div class="checkbox-list">
            <label class="checkbox" title="If checked, any validation error will terminate import process!">
                <input type="checkbox" title="If checked, any validation error will terminate import process!">
                Force Validation On Data Entry
                <span class="ml-3"></span>
            </label>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

<script>
    $(function() {
        $('#kt_repeater_1').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    })
</script>
