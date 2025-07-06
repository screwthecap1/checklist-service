@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Users Management</h1>

        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered mt-4">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="role" class="form-select form-select-sm">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                    <td>
                        @if ($user->blocked)
                            <span class="badge bg-danger">Blocked</span>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.users.toggleBlock', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $user->blocked ? 'btn-success' : 'btn-danger' }}">
                                {{ $user->blocked ? 'Unblock' : 'Block' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No users found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            <a href="{{ route('checklists.index') }}" class="btn btn-secondary">Back to Tasks</a>
        </div>
    </div>
@endsection
