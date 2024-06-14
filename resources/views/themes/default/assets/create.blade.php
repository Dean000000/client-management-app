@extends('themes.default.layouts.layout')

@section('content')
    <h1>Add Asset</h1>

    <form action="{{ route('assets.store') }}\" method="POST\" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="client_id">Client</label>
            <select name="client_id" id="client_id" class="form-control">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->alias }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" id="description" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" id="location" class="form-control">
        </div>
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" id="latitude" class="form-control" readonly>
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" id="longitude" class="form-control" readonly>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <button type="button" class="btn btn-secondary" id="get-location">Get Current Location</button>
        <button type="submit" class="btn btn-primary">Add Asset</button>
    </form>

    <script>
        document.getElementById('get-location').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        });
    </script>
@endsection
