@extends('client.layouts.master')
@section('content')

    <h1>Create New Ticket</h1>

    <form action="{{ route('ticket.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection