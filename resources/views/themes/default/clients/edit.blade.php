@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Client</h1>
        <form action="{{ route('clients.update', $client) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="alias" class="form-label">Alias</label>
                <input type="text" name="alias" id="alias" class="form-control" value="{{ $client->alias }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $client->email }}">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ $client->phone }}">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ $client->address }}">
            </div>
            <button type="submit" class="btn btn-primary">Update Client</button>
        </form>
    </div>
@endsection
