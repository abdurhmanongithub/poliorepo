<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('sub_category.assign_approver') }}" method="POST"> @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Approver</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="sub_category_id" value="{{$subCategory->id}}">



                        <div class="form-group col-md-12">
                            <label for="">Users</label>
                            <select name="user_id" class="form-control " id="user_id">


                                <option value="">Select user</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Approver</button>
                </div>
            </form>
        </div>
    </div>
</div>
