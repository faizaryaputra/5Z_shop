@extends('layouts.admin')

@section('title', isset($menu) ? 'Edit Menu' : 'Tambah Menu')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="flex items-center space-x-2 mb-6">
        <i class="bi bi-pencil-square text-indigo-600 text-3xl"></i>
        <h2 class="text-3xl font-bold text-gray-800 tracking-wide">
            {{ isset($menu) ? 'Edit Menu' : 'Tambah Menu' }}
        </h2>
    </div>

    <form action="{{ isset($menu) ? route('admin.menus.update', $menu->id) : route('admin.menus.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl shadow-xl space-y-6">
        @csrf
        @if(isset($menu))
            @method('PUT')
        @endif

        {{-- Nama Menu --}}
        <div>
            <label for="name" class="block mb-1 text-sm font-semibold text-gray-700">Nama Menu</label>
            <input type="text" name="name" id="name" value="{{ old('name', $menu->name ?? '') }}"
                class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-indigo-500 text-gray-800 shadow-sm">
        </div>

        {{-- Harga --}}
        <div>
            <label for="price" class="block mb-1 text-sm font-semibold text-gray-700">Harga (Rp)</label>
            <input type="number" name="price" id="price" value="{{ old('price', $menu->price ?? '') }}"
                class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-green-500 text-gray-800 shadow-sm">
        </div>

        {{-- Kategori --}}
        <div>
            <label for="category" class="block mb-1 text-sm font-semibold text-gray-700">Kategori</label>
            <select name="category_id" id="category_id"
    class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-yellow-500 text-gray-800 shadow-sm">
    <option value="">-- Pilih Kategori --</option>
    @foreach($categories as $category)
        <option value="{{ $category->id }}" @selected(old('category_id', $menu->menu_category_id ?? '') == $category->id)>
            {{ $category->name }}
        </option>
    @endforeach
</select>
        </div>

        {{-- Foto Menu --}}
        <div>
            <label for="image" class="block mb-1 text-sm font-semibold text-gray-700">Foto Menu</label>
            <input type="file" name="image" id="image"
                class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                       file:rounded-xl file:border-0
                       file:bg-indigo-100 file:text-indigo-700
                       hover:file:bg-indigo-200 shadow-sm" />
            @if(isset($menu) && $menu->image)
                <div class="mt-4">
                    <img src="{{ asset('storage/' . $menu->image) }}" alt="Menu Image" class="w-32 h-auto rounded-lg shadow-md border">
                </div>
            @endif
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-between pt-4">
            <a href="{{ route('admin.menus.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-800 text-sm font-medium rounded-xl shadow hover:bg-gray-200 transition">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-xl shadow hover:bg-indigo-700 transition">
                <i class="bi bi-save"></i> {{ isset($menu) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection
