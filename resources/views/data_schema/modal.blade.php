<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="form-group">
                        <label for="edit_name">Schema Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control"
                            placeholder="Category Name">
                    </div>
                    <div class="form-group">
                        <label for="">Sub Category</label>
                        <select id="edit_sub_category" name="sub_category_id" class="form-control "
                            id="sub_category_id">
                            <option value="">Select Sub Category</option>
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                            @endforeach
                        </select>
                        @error('sub_category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <div class="checkbox-list">
                            <label class="checkbox"
                                title="If checked, any validation error will terminate import process!">
                                <input id="forceValidation" name="force_validation" type="checkbox"
                                    title="If checked, any validation error will terminate import process!">
                                Force Validation On Data Entry
                                <span class="ml-3"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="addForm" method="POST" action="{{ route('data_schema.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name">Schema Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control"
                            placeholder="Category Name">
                    </div>
                    <div class="form-group">
                        <label for="">Sub Category</label>
                        <select id="edit_category" name="sub_category_id" class="form-control " id="sub_category_id">
                            <option value="">Select Sub Category</option>
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                            @endforeach
                        </select>
                        @error('sub_category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <div class="checkbox-list">
                            <label class="checkbox"
                                title="If checked, any validation error will terminate import process!">
                                <input type="checkbox"
                                    title="If checked, any validation error will terminate import process!">
                                Force Validation On Data Entry
                                <span class="ml-3"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
