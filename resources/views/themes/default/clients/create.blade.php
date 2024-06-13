@extends('themes.default.layouts.layout')

@section('content')
    <div class="container">
        <h1>Add Client</h1>
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="alias" class="form-label">Alias</label>
                <input type="text" name="alias" id="alias" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Add Client</button>
        </form>
    </div>
@endsection
