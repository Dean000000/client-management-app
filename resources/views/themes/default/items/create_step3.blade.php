@extends('themes.default.layouts.layout')

@section('content')
    <h1>Select Status</h1>
    <form action="{{ route('items.create.step3.post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="status">Status</label>
                        <input type="text" name="status" id="status" class="form-control" value="1">

            </select>
        </div>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
@endsection
