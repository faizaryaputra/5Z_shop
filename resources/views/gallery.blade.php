@extends('layouts.app')

@section('title', 'Galeri')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/gallery.css') }}">
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush

@section('content')
@include('component.navbar')
<section class="gallery" id="gallery">
  <div class="title">
    <h2>CafeShop <span>Gallery</span></h2>
  </div>
  <div class="container gallery-container">
    <div class="gallery-buttons">
      <button class="btn gallery-tab active" onclick="tabOpen('all')">All</button>
      <button class="btn gallery-tab" onclick="tabOpen('webdevelop')">Front-end</button>
      <button class="btn gallery-tab" onclick="tabOpen('webdesign')">UI/UX</button>
      <button class="btn gallery-tab" onclick="tabOpen('appdevelop')">App</button>
    </div>
    <div class="tab-content active-content" id="all">
      <div class="image"><img src="{{ asset('images/gallery/img1.png') }}" alt=""></div>
      <!-- Tambahkan lainnya -->
    </div>
    <!-- Konten tab lainnya bisa ditambahkan sesuai struktur lama -->
  </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/gallery.js') }}"></script>
<script src="https://unpkg.com/scrollreveal"></script>
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
@endpush
