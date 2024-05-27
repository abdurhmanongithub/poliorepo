@extends('base')
@section('title', 'Edit sub category')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('knowledge.update', $knowledge->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="subcategory">Subcategory:</label>
                        <select name="subcategory_id" id="subcategory" class="form-control">
                            @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}" {{ $subcategory->id == $knowledge->subcategory_id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="knowledgetype">Knowledge Type:</label>
                        <select name="knowledgetype_id" id="knowledgetype" class="form-control">
                            @foreach($knowledgetypes as $knowledgetype)
                            <option value="{{ $knowledgetype->id }}" {{ $knowledgetype->id == $knowledge->knowledgetype_id ? 'selected' : '' }}>{{ $knowledgetype->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea name="message" id="message" class="form-control" rows="5">{{ $knowledge->message }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>class="btn btn-primary">

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
