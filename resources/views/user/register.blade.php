<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: url('/images/caffeshop.jpg') no-repeat;
    background-size: cover;
    background-position: center;
}

.wrapper {
    width: 400px;
    background: transparent;
    border: 2px solid #000000;
    backdrop-filter: blur(10px);
    box-shadow: 0 0 10px #000000;
    color: #ffffff;
    border-radius: 15px;
    padding: 30px 40px;
}

.wrapper h1 {
    font-size: 36px;
    text-align: center;
}

.input-box {
    width: 100%;
    margin: 20px 0;
    position: relative;
}

.input-box input {
    width: 100%;
    padding: 12px;
    background: transparent;
    border: 2px solid #000000;
    border-radius: 25px;
    font-size: 16px;
    color: #ffffff;
}

.input-box input::placeholder {
    color: #ffffff;
}

.input-box i {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    font-size: 18px;
    cursor: pointer;
}

.btn {
    width: 100%;
    height: 50px;
    background: #000000;
    border: none;
    outline: none;
    border-radius: 40px;
    cursor: pointer;
    font-size: 16px;
    color: #ffffff;
    font-weight: 600;
}

.btn:hover {
    background: #333333;
}

.register-link {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
}

.register-link p a {
    color: #ffffff;
    text-decoration: none;
    font-weight: bold;
}

.register-link p a:hover {
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
        <form id="registerForm" action="{{ route('user.register') }}" method="POST">
    @csrf
    <h1>Register</h1>
    <div class="input-box">
        <input type="text" name="name" placeholder="Username" required>
        <i class="ri-user-line"></i>
    </div>
    <div class="input-box">
        <input type="email" name="email" placeholder="Email" required>
        <i class="ri-mail-line"></i>
    </div>
    <div class="input-box">
        <input type="password" id="password" name="password" placeholder="Password" required>
        <i class="ri-eye-off-line" id="togglePassword"></i>
    </div>
    <div class="input-box">
        <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Konfirmasi Password" required>
        <i class="ri-eye-off-line"></i>
    </div>
    <button type="submit" class="btn">Register</button>
    <div class="register-link">
        <p>Sudah punya akun? <a href="{{ route('user.login') }}">Login</a></p>
    </div>
</form>
    </div>

    </body>

<script>
    document.getElementById("registerForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Hindari submit default jika pakai JS
    this.submit();
});

 document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');

    togglePassword.addEventListener('click', function () {
        if (password.type === 'password') {
            password.type = 'text';
            confirmPassword.type = 'text';
            togglePassword.classList.remove('ri-eye-off-line');
            togglePassword.classList.add('ri-eye-line');
        } else {
            password.type = 'password';
            confirmPassword.type = 'password';
            togglePassword.classList.remove('ri-eye-line');
            togglePassword.classList.add('ri-eye-off-line');
        }
    });

    document.getElementById('registerForm').addEventListener('submit', function (event) {
        if (password.value !== confirmPassword.value) {
            alert('Password dan Konfirmasi Password tidak cocok!');
            event.preventDefault();
        }
    });
});

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