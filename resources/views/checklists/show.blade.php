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
                    {{-- Форма для изменения статуса чекбокса --}}
                    <form action="{{ route('checklists.items.update', [$checklist, $item]) }}" method="POST" class="d-flex align-items-center w-100">
                        @csrf
                        @method('PUT')
                        <div class="form-check flex-grow-1">
                            <input type="hidden" name="completed" value="0">
                            <input type="checkbox" name="completed" class="form-check-input" id="item-{{ $item->id }}"
                                   onchange="this.form.submit()" value="1" {{ $item->completed ? 'checked' : '' }}>
                            <label class="form-check-label {{ $item->completed ? 'text-decoration-line-through' : '' }}"
                                   for="item-{{ $item->id }}">
                                {{ $item->content }}
                            </label>
                        </div>
                    </form>

                    {{-- Кнопка для удаления пункта --}}
                    <form action="{{ route('checklists.items.destroy', [$checklist, $item]) }}" method="POST" class="ms-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </li>
            @empty
                <li class="list-group-item text-muted">No items yet.</li>
            @endforelse
        </ul>

        {{-- Форма для добавления нового пункта --}}
        <form action="{{ route('checklists.items.store', $checklist) }}" method="POST" class="mt-4">
            @csrf
            <div class="input-group">
                <input type="text" name="content" class="form-control @error('content') is-invalid @enderror"
                       placeholder="New item..." value="{{ old('content') }}">
                <button class="btn btn-success" type="submit">Add</button>
            </div>
            @error('content')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </form>

        {{-- Ссылка для возврата к списку чек-листов --}}
        <div class="mt-4">
            <a href="{{ route('checklists.index') }}" class="btn btn-secondary">Back to Checklists</a>
        </div>
    </div>
@endsection
