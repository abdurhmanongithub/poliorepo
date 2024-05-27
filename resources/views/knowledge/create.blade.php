@extends('base')
@section('title', 'Create a new Knoweledge')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">

            Knowledge Creation
        </div>
        <div class="card-body">
            <form action="{{ route('knowledge.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="subcategory">Subcategory:</label>
                    <select name="sub_category_id" id="subcategory" class="form-control select2">

                        <option value="" disabled selected>Please select Option</option>
                        @foreach($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="knowledgetype">Knowledge Type:</label>
                    <select name="knowledge_type_id" id="knowledgetype" class="form-control select2">

                        <option value="" disabled selected>Please select Option</option>
                        @foreach($knowledgetypes as $knowledgetype)
                        <option value="{{ $knowledgetype->id }}">{{ $knowledgetype->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea name="message" id="message" class="form-control" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection
