@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Checklist</h1>

        @if ($errors->any())
            <div class="alert alert-danger mt-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checklists.update', $checklist) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Checklist Title</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $checklist->title) }}">
                @error('title')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Checklist</button>
            <a href="{{ route('checklists.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
@endsection
