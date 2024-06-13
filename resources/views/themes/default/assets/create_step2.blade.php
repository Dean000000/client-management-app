@extends('themes.default.layouts.layout')

@section('content')
    <h1>Enter Description</h1>
    <form action="{{ route('assets.create.step2.post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" id="description" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
@endsection
