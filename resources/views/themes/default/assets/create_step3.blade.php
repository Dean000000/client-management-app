@extends('themes.default.layouts.layout')

@section('content')
    <h1>Select Status</h1>
    <form action="{{ route('assets.create.step3.post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
@endsection
