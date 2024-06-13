@extends('themes.default.layouts.layout')

@section('content')
    <h1>Assets</h1>
    <a href="{{ route('assets.create') }}" class="btn btn-primary">Add Asset</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Description</th>
                <th>Status</th>
                <th>Location</th>
                <th>Image</th> <!-- Add a new column for Image -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assets as $asset)
                <tr>
                    <td>{{ $asset->id }}</td>
                    <td>{{ $asset->client->alias }}</td>
                    <td>{{ $asset->description }}</td>
                    <td>{{ $asset->status }}</td>
                    <td>{{ $asset->location }}</td>
                    <td>
                        @if ($asset->image_path)
                            <img src="{{ asset('storage/' . $asset->image_path) }}" alt="{{ $asset->description }}" style="width: 100px; height: auto;">
                        @else
                            No image
                        @endif
                    </td> <!-- Add the image preview here -->
                    <td>
                        <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
