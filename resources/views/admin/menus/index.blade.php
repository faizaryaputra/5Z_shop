@extends('layouts.admin')

@section('title', 'Manajemen Menu')

@section('content')
<div class="p-6 space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            <i class="bi bi-menu-app-fill text-indigo-600 text-4xl"></i>
            Manajemen Menu
        </h2>
        <a href="{{ route('admin.menus.create') }}"
   class="inline-block px-4 py-2 bg-red-600 text-black font-semibold rounded-xl shadow hover:bg-green-700 transition no-underline leading-none tracking-tight focus:outline-none focus:ring-0 border-none">
   + Tambah Menu
</a>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Menu Cards --}}
    @if($menus->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($menus as $menu)
            <div class="bg-white rounded-2xl shadow hover:shadow-xl transition duration-300">
                <div class="relative">
                    <img src="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://source.unsplash.com/300x200/?food' }}"
                         alt="{{ $menu->name }}"
                         class="rounded-t-2xl w-full h-48 object-cover">
                    <div class="absolute top-2 right-2 bg-indigo-600 text-white text-sm px-3 py-1 rounded-xl shadow">
                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                    </div>
                </div>
                <div class="p-4 space-y-2">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $menu->name }}</h3>
                    <p class="text-sm text-gray-500">Kategori: {{ $menu->category->name ?? '-' }}</p>
                    <div class="flex justify-between pt-3">
                        <a href="{{ route('admin.menus.edit', $menu->id) }}"
                           class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center text-red-600 hover:text-red-800 text-sm font-medium transition">
                                🗑 Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $menus->links() }}
    </div>
    @else
        {{-- Kosong --}}
        <div class="text-center text-gray-500 text-lg mt-12">
            <p>Belum ada menu.</p>
            <a href="{{ route('admin.menus.create') }}"
   class="inline-block px-4 py-2 bg-red-600 text-black font-semibold rounded-xl shadow hover:bg-green-700 transition no-underline leading-none tracking-tight focus:outline-none focus:ring-0">
   + Tambah Menu
</a>
        </div>
    @endif
</div>
@endsection
