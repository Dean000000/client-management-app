@extends('themes.default.layouts.layout')

@section('content')
    <h1>Enter Location</h1>
    <form action="{{ route('assets.create.step4.post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ $client->address }}">
        </div>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
@endsection
