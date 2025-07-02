@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Kategori</h2>
        <a href="{{ route('admin.menu-categories.create') }}" class="btn btn-success">+ Tambah Kategori</a>
    </div>
    <table class="table table-bordered bg-white rounded shadow">
        <thead class="bg-gray-100">
            <tr>
                <th>Nama</th>
                <th class="text-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
                <tr>
                    <td>{{ $cat->name }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.menu-categories.edit', $cat->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.menu-categories.destroy', $cat->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
