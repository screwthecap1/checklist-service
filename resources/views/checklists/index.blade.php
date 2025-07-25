@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Checklists</h1>

        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-2">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('checklists.create') }}" class="btn btn-primary">Create New Checklist</a>
        </div>

        @if (auth()->user() && auth()->user()->isAdmin())
            <div class="mb-4">
                <a href="{{ route('admin.users.index') }}" class="btn btn-warning">Admin Panel</a>
            </div>
        @endif


    @if ($checklists->isEmpty())
            <div class="alert alert-info">
                You don't have any checklists yet.
            </div>
        @else
            <div class="list-group">
                @foreach ($checklists as $checklist)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('checklists.show', $checklist) }}" class="fw-bold text-decoration-none">
                                {{ $checklist->title }}
                            </a>
                            <small class="text-muted d-block">Created: {{ $checklist->created_at->format('d M Y H:i') }}</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('checklists.edit', $checklist) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('checklists.destroy', $checklist) }}" method="POST" onsubmit="return confirm('Delete this checklist?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
