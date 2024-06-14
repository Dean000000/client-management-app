<!DOCTYPE html>
<html>
<head>
    <title>Assets Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #000;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Assets Report</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Description</th>
                <th>Status</th>
                <th>Location</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assets as $asset)
                <tr>
                    <td>{{ $asset->id }}</td>
                    <td>{{ $asset->client->alias }}</td>
                    <td>{{ $asset->description }}</td>
                    <td>{{ $asset->status->name }}</td>
                    <td>{{ $asset->location }}</td>
                    <td>{{ $asset->latitude }}</td>
                    <td>{{ $asset->longitude }}</td>
                    <td>
                        @if ($asset->image_path)
                            <img src="{{ public_path('storage/' . $asset->image_path) }}" alt="{{ $asset->description }}" style="width: 50px; height: auto;">
                        @else
                            No image
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
