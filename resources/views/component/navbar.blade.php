<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link href="https://unpkg.com/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
/* ======================================================
                    VARIABLES & GENERAL CSS
========================================================*/
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  text-decoration: none;
  list-style: none;
  resize: none;
  outline: none;
  border: none;
}

:root {
  --color-bg: #e1e1e1;
  --color-text: #212121;
  --color-primary: linear-gradient(45deg, #ff6600, #00c8ff); /* Gradient Orange -> Light Blue */
  --color-secondary: linear-gradient(45deg, #e65c00, #0099cc); 
  --color-tertiary:rgb(0, 200, 255);

  --shadow: 6px 6px 12px #bababa, -6px -6px 12px #ffffff;
  --inner-shadow: inset 6px 6px 12px #bababa, inset -6px -6px 12px #ffffff;

  --width-lg: 80%;
  --width-sm: 95%;
  --transition: all 0.4s ease-in;
}

nav {
  padding: 0.3rem 0;
  transition: 0.3s ease-in-out;
  -webkit-transition: 0.3s ease-in-out;
  -moz-transition: 0.3s ease-in-out;
  -ms-transition: 0.3s ease-in-out;
  -o-transition: 0.3s ease-in-out;
  position: fixed;
  top: 0;
  width: 100%;
  background: var(--color-bg);
  z-index: 11111;
  box-shadow: var(--shadow);
}
.nav-container {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 2rem;
  width: 100%;
  height: 70px; /* atur tinggi sesuai kebutuhan */
}

.navlist {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 2rem;
  list-style: none;
}

.navlist li a {
  text-transform: capitalize;
  font-weight: 500;
}
.navlist li a:hover {
  color: var(--color-tertiary);
}
.logo img {
  height: 60px;
  width: 100%;
  box-shadow: var(--shadow);
  border-radius: 0.5rem;
  padding: 0.2rem 0.2rem;
}
.nav-icons {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 1rem;
}
.nav-icons div {
  padding: 0.5rem 1rem;
  margin: 0.5rem;
  color: var(--color-text);
  background: var(--color-bg);
  box-shadow: var(--shadow);
  border-radius: 0.3rem;
  -webkit-border-radius: 0.3rem;
  -moz-border-radius: 0.3rem;
  -ms-border-radius: 0.3rem;
  -o-border-radius: 0.3rem;
  cursor: pointer;
}
.nav-icons div:hover {
  color: var(--color-tertiary);
  box-shadow: var(--inner-shadow);
}
#menu-btn {
  display: none;
}
.btn-login {
  padding: 0.5rem 1rem;
  background: var(--color-primary);
  color: white;
  border-radius: 0.3rem;
  border-radius: 15px;
  text-decoration: none;
  font-weight: 500;
  transition: 0.3s ease;
}

.btn-login:hover {
  background: var(--color-secondary);
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}

/* Avatar Styling */
.avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;        /* Bulat sempurna */
  object-fit: cover;         /* Isi penuh */
  cursor: pointer;           /* Tunjukkan interaksi */
  border: none;              /* Hapus border */
  background: transparent;   /* Tidak ada latar */
  display: block;
  padding: 0;
  margin: 0;
  transition: box-shadow 0.3s ease;
  box-shadow: 0 0 0 2px var(--color-primary, #007bff);
}

.avatar:hover {
  box-shadow: 0 0 0 2px var(--color-primary, #007bff); /* Hover effect */
}

/* Dropdown Container */
.dropdown {
  position: relative;
  display: flex;
  align-items: center;
  z-index: 100;
}

/* Dropdown Content */
.dropdown-content {
  display: none;
  position: absolute;
  right: 0;
  top: 50px;
  background-color: #fff;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  padding: 0.75rem 1rem;
  border-radius: 0.5rem;
  z-index: 999;
  min-width: 180px;
}

.dropdown-content a,
.dropdown-content button {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 8px 0;
  width: 100%;
  background: none;
  border: none;
  cursor: pointer;
  text-align: left;
  font-size: 14px;
  color: var(--color-text, #333);
  text-decoration: none;
  transition: background-color 0.2s ease, color 0.2s ease;
}

.dropdown-content a:hover,
.dropdown-content button:hover {
  color: var(--color-primary, #007bff);
}

.dropdown.show .dropdown-content {
  display: block;
}

</style>
    <body>
    @if(Auth::check())
    <p>User Login: {{ Auth::user()->name }}</p>
@else
    <p>User tidak login</p>
@endif
    <!-- ==================================
                    NAVBAR
    ==================================== -->
    <nav>
  <div class="container nav-container">
    <a href="{{ route('home') }}" class="logo">
      <img src="{{ asset('images/5Z.png') }}" alt="Logo Cafe">
    </a>

    <ul class="navlist">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li><a href="{{ route('about') }}">About</a></li>
      <li><a href="{{ route('menu.index') }}">Menu</a></li>
      <li><a href="{{ route('gallery') }}">Gallery</a></li>
      <li><a href="{{ route('contact') }}">Contact</a></li>
    </ul>

    <div class="nav-icons">
      <div id="theme-btn" class="ri-moon-line" title="Toggle Theme"></div>
      <div id="menu-btn" class="ri-menu-line" title="Toggle Menu"></div>

      @auth
<div class="dropdown" id="dropdown">
  <img 
    src="{{ Auth::user()->avatar }}" 
    alt="Avatar"
    class="avatar"
    onclick="toggleDropdown()"
    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}';"
  >

  <div class="dropdown-content" id="dropdownMenu">
    <a href="{{ route('user.profile-settings') }}"><i class="fas fa-user-cog"></i> Akun Saya</a>
    <a href="{{ route('user.payment') }}"><i class="fas fa-credit-card"></i> Pembayaran</a>
    <form action="{{ route('user.logout') }}" method="POST" style="margin: 0;">
      @csrf
      <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
  </div>
</div>
@endauth

@guest
  <a href="{{ route('user.login') }}" class="btn-login">
  <i class="fas fa-sign-in-alt"></i> Login
</a>

@endguest
    </div>
  </div>
</nav>

</body>

<script>
// ============== MENU NAVBAR ================
const navlist = document.querySelector(".navlist");
const menuBtn = document.querySelector(".ri-menu-line");

menuBtn.onclick = function () {
  navlist.classList.toggle("active");
  menuBtn.classList.toggle("ri-arrow-up-double-line");
};
// ============== STICKY NAVBAR ================
window.addEventListener("scroll", () => {
  document.querySelector("nav").classList.toggle("scrolling", scrollY > 50);
});

// ============== PROJECT TABS ================
let projectTabs = document.getElementsByClassName("project-tab");
let tabContents = document.getElementsByClassName("tab-content");

function tabOpen(x) {
  for (projectTab of projectTabs) {
    projectTab.classList.remove("active");
  }
  for (tabContent of tabContents) {
    tabContent.classList.remove("active-content");
  }
  event.currentTarget.classList.add("active");
  document.getElementById(x).classList.add("active-content");
}

// ============== DARK THEME================
let themeBtn = document.querySelector("#theme-btn");

themeBtn.onclick = function () {
  themeBtn.classList.toggle("ri-sun-line");
  if (themeBtn.classList.contains("ri-sun-line")) {
    document.body.classList.add("active");
  } else {
    document.body.classList.remove("active");
  }
};

function toggleDropdown() {
        const dropdown = document.getElementById('dropdown');
        dropdown.classList.toggle('show');
    }

    // Tutup dropdown jika klik di luar area
    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('dropdown');
        const menu = document.getElementById('dropdownMenu');
        const avatar = dropdown.querySelector('.avatar');

        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });

</script>
</body>
</html>