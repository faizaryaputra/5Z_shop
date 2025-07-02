@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
@include('component.navbar')

    <!-- ==================================
                  HOME SECTION
    ==================================== -->
    <section class="home" id="home">
  <div class="container home-container">
    <div class="center">
    <img src="images/5Zcaffeshop.jpg" alt="Logo" class="logo">
    <h3><div class="multiple-text">Smart Coffee for a Smarter You</div></h3>
      <div class="social-icons-container">
        <div class="social-icons">
          <a href="https://instagram.com" target="_blank"><i class="ri-instagram-line"></i></a>
          <a href="https://whatsapp.com" target="_blank"><i class="ri-whatsapp-line"></i></a>
          <a href="https://github.com" target="_blank"><i class="ri-github-line"></i></a>
          <a href="https://linkedin.com" target="_blank"><i class="ri-linkedin-line"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>
    <!-- ==================================
                  ABOUT SECTION
    ==================================== -->
    <section class="about" id="about">
      <div class="container about-container">
        <div class="left">
          <!-- add your photo in src for About page from assets/images/ -->
          <img src="assets/images/profile.png" alt="" />
        </div>
        <div class="right">
          <div class="title">
            <h2>Cafe <span>5Z</span></h2>
          </div>
          <h3>
            CAFE 5Z
          </h3>
          <p>
          I am an active Gunadarma University student majoring in Information Systems with a strong passion for UI/UX design, front-end development, and back-end development.
          </p>
          <button class="btn overlay">
            <span>Download CV</span>
          </button>
          <div class="container">
            <div class="progress-bar">
              <div class="outer-circle">
                <div class="inner-circle">
                  <div class="html-number number">
                    <h4>UI/UX Designer</h4>
                  </div>
                </div>
              </div>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                version="1.1"
                width="160px"
                height="160px"
              >
                <defs>
                  <linearGradient id="GradientColor">
                    <stop offset="0%" stop-color="rgb(47, 206, 255)" />
                    <stop offset="100%" stop-color="rgb(255, 123, 0)" />
                  </linearGradient>
                </defs>
                <circle cx="80" cy="80" r="70" stroke-linecap="round" />
              </svg>
            </div>
            <div class="progress-bar">
              <div class="outer-circle">
                <div class="inner-circle">
                  <div class="html-number number">
                    <h4>Front-end dev</h4>
                  </div>
                </div>
              </div>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                version="1.1"
                width="160px"
                height="160px"
              >
                <defs>
                  <linearGradient id="GradientColor">
                    <stop offset="0%" stop-color="rgb(47, 206, 255)" />
                    <stop offset="100%" stop-color="rgb(255, 123, 0)" />
                  </linearGradient>
                </defs>
                <circle cx="80" cy="80" r="70" stroke-linecap="round" />
              </svg>
            </div>
            <div class="progress-bar">
              <div class="outer-circle">
                <div class="inner-circle">
                  <div class="html-number number">
                    <h4>Back-end dev</h4>
                  </div>
                </div>
              </div>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                version="1.1"
                width="160px"
                height="160px"
              >
                <defs>
                  <linearGradient id="GradientColor">
                    <stop offset="0%" stop-color="rgb(47, 206, 255)" />
                    <stop offset="100%" stop-color="rgb(255, 123, 0)" />
                  </linearGradient>
                </defs>
                <circle cx="80" cy="80" r="70" stroke-linecap="round" />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </section>
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

<!-- GALLERY SECTION -->
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

<!-- CONTACT SECTION -->
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

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://unpkg.com/scrollreveal"></script>
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
<script src="{{ asset('js/home.js') }}"></script>
@endpush
