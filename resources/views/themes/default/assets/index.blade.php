@extends('themes.default.layouts.layout')

@section('content')
    <h1>Assets</h1>
    <a href="{{ route('assets.create.step1') }}" class="btn btn-primary">Add Asset</a>
    <a href="{{ route('assets.export.all') }}" class="btn btn-secondary">Export All Assets</a>

    <form action="{{ route('assets.export.client', ['client' => 'client_id_placeholder']) }}" method="GET" class="form-inline" id="export-client-form">
        <select name="client_id" class="form-control" id="client-select">
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->alias }}</option>
            @endforeach
        </select>
        <select name="status_id" class="form-control">
            <option value="">All Statuses</option>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}">{{ $status->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary">Export By Client and Status</button>
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Description</th>
                <th>Status</th>
                <th>Location</th>
                <th>Image</th>
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
                    </td>
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

    <script>
        document.getElementById('export-client-form').addEventListener('submit', function (event) {
            var clientId = document.getElementById('client-select').value;
            this.action = this.action.replace('client_id_placeholder', clientId);
        });
    </script>
@endsection
