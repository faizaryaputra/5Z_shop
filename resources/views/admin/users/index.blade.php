@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="p-6 space-y-6">
    <h2 class="text-2xl font-bold mb-4">Manajemen Pengguna</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered bg-white rounded shadow">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->diffForHumans() }}</td>
                <td>
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info">Lihat</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin hapus user ini?')" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
