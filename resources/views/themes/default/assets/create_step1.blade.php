@extends('themes.default.layouts.layout')

@section('content')
    <h1>Select Client</h1>
    <form action="{{ route('assets.create.step1.post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="client_id">Client</label>
            <input type="text" id="client-search" class="form-control" placeholder="Search for client...">
            <ul id="client-suggestions">
                @foreach ($recentClients as $client)
                    <li data-client-id="{{ $client->id }}">{{ $client->alias }}</li>
                @endforeach
            </ul>
            <input type="hidden" name="client_id" id="client_id">
        </div>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>

    <script>
        document.getElementById('client-search').addEventListener('input', function () {
            var query = this.value;
            fetch(`/search-clients?query=${query}`)
                .then(response => response.json())
                .then(clients => {
                    var suggestions = clients.map(client => `<li data-client-id="${client.id}">${client.alias}</li>`).join('');
                    document.getElementById('client-suggestions').innerHTML = suggestions;
                    document.querySelectorAll('#client-suggestions li').forEach(item => {
                        item.addEventListener('click', function () {
                            document.getElementById('client_id').value = this.dataset.clientId;
                            document.getElementById('client-search').value = this.innerText;
                            document.getElementById('client-suggestions').innerHTML = '';
                        });
                    });
                });
        });
    </script>
@endsection
