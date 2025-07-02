@extends('layouts.app')

@section('title', 'Galeri')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/about.css') }}">
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush

@section('content')
@include('component.navbar')
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
@endsection

@push('scripts')
<script src="{{ asset('js/about.js') }}"></script>
<script src="https://unpkg.com/scrollreveal"></script>
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
@endpush
