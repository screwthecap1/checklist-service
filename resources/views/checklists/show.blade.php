@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $checklist->title }}</h1>

        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

        {{-- Список пунктов --}}
        <ul class="list-group my-4">
            @forelse ($checklist->items as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <form action="{{ route('checklists.items.update', [$checklist, $item]) }}" method="POST" class="d-flex align-items-center w-100">
                        @csrf
                        @method('PUT')
                        <div class="form-check flex-grow-1">
                            <input type="checkbox" name="completed" class="form-check-input" id="item-{{ $item->id }}" onchange="this.form.submit()" {{ $item->completed ? 'checked' : '' }}>
                            <label class="form-check-label {{ $item->completed ? 'text-decoration-line-through' : '' }}" for="item-{{ $item->id }}">
                                {{ $item->content }}
                            </label>
                        </div>
                    </form>
                    <div class="ms-3">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('edit-item-{{ $item->id }}').submit();" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('checklists.items.destroy', [$checklist, $item]) }}" method="POST" class="d-inline" id="delete-item-{{ $item->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="list-group-item text-muted">No items yet.</li>
            @endforelse
        </ul>

        {{-- Добавление нового пункта --}}
        <form action="{{ route('checklists.items.store', $checklist) }}" method="POST" class="mt-4">
            @csrf
            <div class="input-group">
                <input type="text" name="content" class="form-control @error('content') is-invalid @enderror" placeholder="New item..." value="{{ old('content') }}">
                <button class="btn btn-success" type="submit">Add</button>
            </div>
            @error('content')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </form>

        {{-- Ссылка вернуться к списку чек-листов --}}
        <div class="mt-4">
            <a href="{{ route('checklists.index') }}" class="btn btn-secondary">Back to Checklists</a>
        </div>
    </div>
@endsection
