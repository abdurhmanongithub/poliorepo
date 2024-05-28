<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Zone</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="form-group">
                        <label for="edit_name">Zone</label>
                        <input type="text" name="name" id="edit_name" class="form-control" placeholder="Zone Name">
                    </div>
                    <div class="form-group">
                        <label for="">Region</label>
                        <select id="edit_category" name="region_id" class="form-control select2 " id="region_id">


                            <option value="">Select Region</option>
                            @foreach ($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>

                            @endforeach
                        </select>
                        @error('region_id')

                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_description">code</label>
                        <input name="code" id="edit_description" class="form-control" />

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
            <form id="addForm" method="POST" action="{{ route('zone.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control" placeholder="Zone Name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Region</label>
                            <select name="region_id" class="form-control select2" id="region_id">
                                <option value="">Select Region</option>
                                @foreach ($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                            @error('region_id')

                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Code</label>
                        <input name="code" id="description" class="form-control" value="{{ old('code') }}" />

                        @error('code')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Zone</button>
                </div>
            </form>
        </div>
    </div>
</div>
