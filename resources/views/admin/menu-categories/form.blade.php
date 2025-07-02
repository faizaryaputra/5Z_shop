@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ isset($menuCategory) ? 'Edit' : 'Tambah' }} Kategori</h2>

    <form method="POST" action="{{ isset($menuCategory) ? route('admin.menu-categories.update', $menuCategory->id) : route('admin.menu-categories.store') }}">
        @csrf
        @if(isset($menuCategory)) @method('PUT') @endif

        <div class="mb-4">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $menuCategory->name ?? '') }}" required>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('admin.menu-categories.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">{{ isset($menuCategory) ? 'Update' : 'Simpan' }}</button>
        </div>
    </form>
</div>
@endsection
