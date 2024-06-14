@extends('themes.default.layouts.layout')

@section('content')
    <h1>Edit Item</h1>

    <form action="{{ route('items.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="client_id">Client</label>
            <select name="client_id" id="client_id" class="form-control">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $asset->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->alias }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ $asset->description }}" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ $asset->status == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ $asset->location }}">
        </div>
		   <button type="button" class="btn btn-secondary" id="get-location">Get Current Location</button>
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" id="latitude" class="form-control" value="{{ $asset->latitude }}" readonly>
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" id="longitude" class="form-control" value="{{ $asset->longitude }}" readonly>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if ($asset->image_path)
                <img src="{{ asset('storage/' . $asset->image_path) }}" alt="{{ $asset->description }}" style="width: 100px; height: auto;">
            @else
                No image
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update Asset</button>
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
