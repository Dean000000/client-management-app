<!DOCTYPE html>
<html>
<head>
    <title>Items Report</title>
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
    <h1>Items Report</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Description</th>
                <th>Location</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->client->alias }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->location }}</td>
                    <td>{{ $item->latitude }}</td>
                    <td>{{ $item->longitude }}</td>
                    <td><img src="{{ asset('storage/' . $item->image_path) }}" alt="Item Image" width="100"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
