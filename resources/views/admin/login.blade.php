<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link href="https://unpkg.com/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
     * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
      }

      :root {
  --color-bg: #e1e1e1;
  --color-text: #212121;
  --color-tertiary:rgb(0, 200, 255);
  --color-primary: linear-gradient(45deg, #ff6600, #00c8ff); /* Gradient Orange -> Light Blue */
  --color-secondary: linear-gradient(45deg, #e65c00, #0099cc); 

  --shadow: 6px 6px 12px #bababa, -6px -6px 12px #ffffff;
  --inner-shadow: inset 6px 6px 12px #bababa, inset -6px -6px 12px #ffffff;

  --width-lg: 80%;
  --width-sm: 95%;
  --transition: all 0.4s ease-in;
}

body.active {
  --color-bg: #212121;
  --color-text: #e0e0e0;
  --color-tertiary:rgb(255, 123, 0);

  --shadow: 0.5rem 0.5rem 1rem #111, -6px -6px 12px #333;
  --inner-shadow: inset 0.5rem 0.5rem 1rem #111, inset -6px -6px 12px #333;
}
::-webkit-scrollbar {
  width: 0.5rem;
}
::-webkit-scrollbar-track {
  box-shadow: var(--inner-shadow);
}
::-webkit-scrollbar-thumb {
  box-shadow: var(--shadow);
  background: var(--color-tertiary);
}
      body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: url('/images/caffeshop.jpg') no-repeat;
        background-size: cover;
        background-position: center;
        overflow: hidden;
      }

      img {
  width: 100%;
  display: block;
  object-fit: cover;
}
a {
  color: var(--color-text);
  font-size: 1rem;
}
span,
p {
  font-size: 1rem;
}
h1,
h2,
h3,
h4 {
  line-height: 1.2;
}
h1 {
  font-size: 2.8rem;
}
h2 {
  font-size: 2.1rem;
}
h3 {
  font-size: 2rem;
}
h4 {
  font-size: 1.1rem;
}
.container {
  margin: 0 auto;
  width: var(--width-lg);
}
section {
  padding: 5rem 0 3rem;
  min-height: 100vh;
}
.title {
  text-align: center;
  margin-bottom: 6rem;
}
.title h2 {
  font-size: 2.5rem;
  display: inline-block;
  color: var(--color-text);
  font-weight: 300;
}
.title h2 span {
  font-size: 2.5rem;
  color: var(--color-tertiary);
  font-weight: 900;
}
.btn {
  padding: 1rem 3rem;
  position: relative;
  cursor: pointer;
  overflow: hidden;
  background: transparent;
  color: var(--color-text);
  font-weight: 700;
  border-radius: 0.5rem;
  box-shadow: var(--shadow);
  transition: all 0.5s ease-in-out;
  -webkit-transition: all 0.5s ease-in-out;
  -moz-transition: all 0.5s ease-in-out;
  -ms-transition: all 0.5s ease-in-out;
  -o-transition: all 0.5s ease-in-out;
  -webkit-border-radius: 0.5rem;
  -moz-border-radius: 0.5rem;
  -ms-border-radius: 0.5rem;
  -o-border-radius: 0.5rem;
}
.btn span {
  z-index: 1;
  font-weight: 800;
  letter-spacing: 0.1rem;
}
.btn.overlay::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  background: var(--color-text);
  height: 10px;
  width: 10px;
  z-index: -1;
  border-radius: 0.5rem;
  -webkit-border-radius: 0.5rem;
  -moz-border-radius: 0.5rem;
  -ms-border-radius: 0.5rem;
  -o-border-radius: 0.5rem;
  transition: all 0.6s ease-in-out;
  -webkit-transition: all 0.6s ease-in-out;
  -moz-transition: all 0.6s ease-in-out;
  -ms-transition: all 0.6s ease-in-out;
  -o-transition: all 0.6s ease-in-out;
  visibility: hidden;
}
.btn:hover {
  color: var(--color-tertiary);
  box-shadow: 1px 1px 10px var(--color-tertiary);
}
.btn.overlay:hover::after {
  visibility: visible;
  transform: scale(100);
  -webkit-transform: scale(100);
  -moz-transform: scale(100);
  -ms-transform: scale(100);
  -o-transform: scale(100);
}
.scrollbar::-webkit-scrollbar {
  height: 0.66rem;
}
.scrollbar::-webkit-scrollbar-track {
  border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  -ms-border-radius: 5px;
  -o-border-radius: 5px;
}
.scrollbar::-webkit-scrollbar-thumb {
  border-radius: 0.5rem;
  -webkit-border-radius: 0.5rem;
  -moz-border-radius: 0.5rem;
  -ms-border-radius: 0.5rem;
  -o-border-radius: 0.5rem;
}
.scrollbar::-webkit-scrollbar-button {
  width: 0.8rem;
}
      .wrapper{
        width: 350px;
        background: transparent;
        border: 2px solid #000000;
        backdrop-filter: blur(10px);
        box-shadow: 0 0 10px #000000;
        color: #ffffff;
        border-radius: 15px;
        padding: 30px 40px;
      }

      .wrapper h1{
        font-size: 36px;
        text-align: center;
      }

      .wrapper .input-box{
        width: 100%;
        height: 100%;
        position: relative;
        margin: 25px 0;
      }

      .input-box input{
        width: 100%;
        height: 100%;
        background: transparent;
        border: none;
        outline: none;
        border: 2px solid #000000;
        border-radius: 40px;
        font-size: 16px;
        color: #ffffff;
        padding: 10px 45px 10px 20px;
      }

      .input-box input::placeholder{
        color: #ffffff;
      }

      .input-box i{
        position: absolute;
        top: 25%;
        right: 15px;
        transform: translate(-50%);
        font-size: 20px;
      }

      .wrapper .remember-forgot{
        display: flex;
        justify-content: space-between;
        font-size: 14.5px;
        margin: -15px 0 15px;
      }

      .remember-forgot label input{
        accent-color: #ffffff;
        margin-right: 3px;
      }

      .remember-forgot a{
        color: #ffffff;
        text-decoration: none;
      }

      .remember-forgot a:hover{
        text-decoration: underline;
      }

      .wrapper .btn{
        width: 100%;
        height: 50px;
        background: #000000;
        border: none;
        outline: none;
        border-radius: 40px;
        box-shadow: 0 0 10px #000000;
        cursor: pointer;
        font-size: 16px;
        color: #333333;
        font-weight: 600;
      }

      .wrapper .register-link{
        margin-top: 20px;
        font-size: 14.5px;
        text-align: center;
      }

      .google-btn {
    width: 100%;
    height: 50px;
    background: #ffffff;
    border: none;
    outline: none;
    border-radius: 40px;
    box-shadow: 0 0 10px #000000;
    cursor: pointer;
    font-size: 16px;
    color: #000000;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 15px;
}

.google-btn:hover {
    background: #f1f1f1;
}

.google-btn i {
    font-size: 20px;
    color: #db4437;
}

      .register-link p a{
        color: #ffffff;
        text-decoration: none;
        font-weight: 600;
      }

      .register-link p a:hover{
        text-decoration: underline;
      }
      .close-btn {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 24px;
    font-weight: bold;
    color: #ffffff;
    cursor: pointer;
    transition: 0.3s;
}

.close-btn:hover {
    color: #ff4d4d;
}

      </style>
<body>
    <div class="wrapper">
        <span class="close-btn" onclick="window.location.href='{{ route('home') }}'">&times;</span>
        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <h1>Admin Login</h1>

            {{-- Tampilkan error jika ada --}}
            @if (session('error'))
                <div class="error-message">{{ session('error') }}</div>
            @endif

            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class="ri-user-line"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class="ri-eye-off-line" id="togglePassword"></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox" name="remember"> Remember me</label>
                {{-- Optional: forgot password --}}
                {{-- <a href="{{ route('admin.password.request') }}">Forgot password?</a> --}}
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        if (password.type === 'password') {
            password.type = 'text';
            togglePassword.classList.remove('ri-eye-off-line');
            togglePassword.classList.add('ri-eye-line');
        } else {
            password.type = 'password';
            togglePassword.classList.remove('ri-eye-line');
            togglePassword.classList.add('ri-eye-off-line');
        }
    });
        const navlist = document.querySelector(".navlist");
const menuBtn = document.querySelector(".ri-menu-line");

menuBtn.onclick = function () {
  navlist.classList.toggle("active");
  menuBtn.classList.toggle("ri-arrow-up-double-line");
};


        let themeBtn = document.querySelector("#theme-btn");

themeBtn.onclick = function () {
  themeBtn.classList.toggle("ri-sun-line");
  if (themeBtn.classList.contains("ri-sun-line")) {
    document.body.classList.add("active");
  } else {
    document.body.classList.remove("active");
  }
};

// ============== TYPED JS ================
const typed = new Typed(".multiple-text", {
  strings: ["Back-end Development", "Front-end Development", "UI/UX Designer"],
  typeSpeed: 100,
  backSpeed: 100,
  backDelay: 1000,
  loop: true,
});

  </script>
</body>
</html>