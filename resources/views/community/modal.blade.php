<div class="modal fade" id="editRegionModal" tabindex="-1" role="dialog" aria-labelledby="editRegionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editRegionForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="editRegionModalLabel">Edit Community</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Community type</label>
                        <select name="zone_id" class="form-control select2" id="zone_id">

                            <option value="">Select</option>
                            @foreach ($communityTypes as $communityType)

                            <option value="{{ $communityType->id }}">{{ $communityType->name }}</option>


                            @endforeach
                        </select>
                        @error('region_id')

                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="form-group">
                        <label for="edit_name">Full Name</label>
                        <input type="text" name="full_name" id="edit_name" class="form-control" placeholder="community type">
                    </div>
                    <div class="form-group">
                        <label for="edit_name">phone</label>
                        <input type="email" name="name" id="edit_name" class="form-control" placeholder="community type">
                    </div>

                    <div class="form-group">
                        <label for="edit_name">email</label>
                        <input type="email" name="name" id="edit_name" class="form-control" placeholder="community type">
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="addForm" method="POST" action="{{ route('community-type.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add community</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Community type</label>
                        <select name="community_type_id" class="form-control select2" id="community_type_id">


                            <option value="">Select</option>
                            @foreach ($communityTypes as $communityType)

                            <option value="{{ $communityType->id }}">{{ $communityType->name }}</option>


                            @endforeach
                        </select>
                        @error('region_id')

                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="form-group">
                        <label for="edit_name">Full Name</label>
                        <input type="text" name="full_name" id="edit_name" class="form-control" placeholder="full name">
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="form-group col-6">
                            <label for="edit_name">phone</label>
                            <input type="text" name="phone" id="edit_name" class="form-control" placeholder="Phone">
                        </div>

                        <div class="form-group col-6">
                            <label for="edit_name">email</label>
                            <input type="email" name="email" id="edit_name" class="form-control" placeholder="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Woreda</label>
                        <select name="woreda_id" class="form-control select2" id="zone_id">

                            <option value="">Select</option>
                            @foreach ($woredas as $woreda)

                            <option value="{{ $woreda->id }}">{{ $woreda->name }}</option>


                            @endforeach
                        </select>
                        @error('region_id')

                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Region</button>
                </div>
            </form>
        </div>
    </div>
</div>
