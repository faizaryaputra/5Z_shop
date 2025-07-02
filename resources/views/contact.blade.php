@extends('layouts.app')

@section('title', 'Galeri')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush

@section('content')
@include('component.navbar')
<section class="contact" id="contact">
  <div class="title">
    <h2>Live <span>Chat</span></h2>
  </div>
  <div class="contact-content">
    <div class="chat-box">
      <div id="chat-messages" class="chat-messages"></div>
      <form action="{{ route('chat.send') }}" method="POST" id="chat-form">
        @csrf
        <input type="text" id="chat-input" name="message" placeholder="Ketik pesan..." required>
        <button type="submit" class="btn overlay"><span>Kirim</span></button>
      </form>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/contact.js') }}"></script>
<script src="https://unpkg.com/scrollreveal"></script>
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
@endpush
