@extends('themes.default.layouts.layout')

@section('content')
    <h1>Upload Image</h1>
    <form action="{{ route('assets.create.step6.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Finish</button>
    </form>
@endsection
