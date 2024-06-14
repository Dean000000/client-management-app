@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Login</h1>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form action="{{ route('sendMagicLink') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Send Magic Link</button>
    </form>
</div>
@endsection
