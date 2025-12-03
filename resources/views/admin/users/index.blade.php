@extends('layout.main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Users</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td class="text-end">
                        <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('PUT')

                            <div class="input-group input-group-sm" style="max-width:220px;">
                                <select name="role" class="form-select form-select-sm">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>user</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>admin</option>
                                </select>
                                <button class="btn btn-primary btn-sm" type="submit">Save</button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $users->links() }}
    </div>

@endsection
