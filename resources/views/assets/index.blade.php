@extends('layout')

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
