@extends('layouts.app')

@section('title', 'Menu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush

@section('content')
@include('component.navbar')
<!-- MENU SECTION -->
<section class="menu" id="menu">
  <div class="title">
    <h2>Our <span>Menu</span></h2>
  </div>
  <div class="container menu-container">
    @foreach(['Hot Coffe', 'Cold Coffe', 'Dessert', 'Food', 'Bread & Pastry', 'Other Drink'] as $menu)
    <div class="box overlay">
      <div class="content">
        <i class="ri-cup-fill"></i>
        <h4>{{ $menu }}</h4>
        <form action="{{ route('orders.create') }}" method="GET">
          <input type="hidden" name="menu" value="{{ $menu }}">
          <button class="btn" type="submit">Order Now</button>
        </form>
      </div>
    </div>
    @endforeach
  </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/menu.js') }}"></script>
<script src="https://unpkg.com/scrollreveal"></script>
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
@endpush