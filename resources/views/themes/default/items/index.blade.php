@extends('themes.default.layouts.layout')

@section('content')
    <h1>Assets</h1>
    <a href="{{ route('items.create.step1') }}" class="btn btn-primary">Add Asset</a>
    <a href="{{ route('items.export.all') }}" class="btn btn-secondary">Export All Assets</a>

    <form action="{{ route('items.export.client', ['client' => 'client_id_placeholder']) }}" method="GET" class="form-inline" id="export-client-form">
        <select name="client_id" class="form-control" id="client-select">
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->alias }}</option>
            @endforeach
        </select>
   
        <button type="submit" class="btn btn-secondary">Export By Client</button>
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Description</th>
                <th>Location</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->client->alias }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->location }}</td>
                    <td>
                        @if ($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->description }}" style="width: 100px; height: auto;">
                        @else
                            No image
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
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
