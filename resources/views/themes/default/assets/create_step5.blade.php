@extends('themes.default.layouts.layout')

@section('content')
    <h1>Get Coordinates</h1>
    <form action="{{ route('assets.create.step5.post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" id="latitude" class="form-control" readonly>
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" id="longitude" class="form-control" readonly>
        </div>
        <button type="button" class="btn btn-secondary" id="get-location">Get Current Location</button>
        <button type="submit" class="btn btn-primary">Next</button>
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
