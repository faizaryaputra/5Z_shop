<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Login</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: url('/images/caffeshop.jpg') center/cover no-repeat;
      transition: 0.5s;
    }

    body.dark-mode {
      background: #1e1e1e;
    }

    .wrapper {
      position: relative;
      width: 380px;
      padding: 40px 30px;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
      color: #fff;
      animation: fadeInUp 1s ease-in-out;
      transition: 0.3s;
    }

    .wrapper h1 {
      font-size: 2.2rem;
      text-align: center;
      margin-bottom: 25px;
    }

    .auth-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      width: 100%;
      padding: 12px;
      border-radius: 40px;
      font-weight: 600;
      font-size: 16px;
      text-decoration: none;
      margin-top: 15px;
      transition: all 0.3s ease-in-out;
      cursor: pointer;
    }

    .google-btn {
      background: #fff;
      color: #333;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }

    .google-btn:hover {
      background: #f2f2f2;
      transform: scale(1.03);
    }

    .google-btn i {
      font-size: 20px;
      color: #db4437;
    }

    .biometric-btn {
      background: linear-gradient(135deg, #00c8ff, #007acc);
      color: #fff;
      box-shadow: 0 0 15px #00c8ff80;
    }

    .biometric-btn:hover {
      background: linear-gradient(135deg, #00a2cc, #005f99);
      transform: scale(1.03);
    }

    .biometric-btn i {
      font-size: 20px;
    }

    .close-btn {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 24px;
      font-weight: bold;
      color: #fff;
      cursor: pointer;
      transition: 0.3s;
    }

    .close-btn:hover {
      color: #ff4d4d;
    }

    .register-link {
      margin-top: 20px;
      font-size: 14px;
      text-align: center;
    }

    .register-link a {
      color: #fff;
      font-weight: bold;
      text-decoration: none;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    .theme-toggle {
      position: absolute;
      top: 15px;
      left: 20px;
      font-size: 22px;
      cursor: pointer;
      color: #fff;
      transition: 0.3s;
    }

    .theme-toggle:hover {
      color: #ffd700;
    }
  </style>
</head>
<body>
  <div class="wrapper" id="loginWrapper">
    <span class="close-btn" onclick="window.location.href='{{ route('home') }}'">&times;</span>
    <h1>Login</h1>

    <a href="{{ route('user.google.login') }}" class="auth-btn google-btn">
      <i class="ri-google-fill"></i> Login with Google
    </a>

    <button type="button" id="biometric-login-btn" class="auth-btn biometric-btn">
      <i class="ri-fingerprint-line"></i> Login dengan Biometrik
    </button>

    <form id="webauthn-login-form" method="POST" action="{{ route('user.webauthn.login') }}">
      @csrf
    </form>

    @if (Auth::check())
      <form method="POST" action="{{ route('user.webauthn.register') }}">
        @csrf
        <button type="submit" class="auth-btn biometric-btn" style="margin-top: 10px;">
          <i class="ri-device-line"></i> Daftarkan Perangkat Biometrik
        </button>
      </form>
    @endif
  </div>

  <script src="https://unpkg.com/@github/webauthn-json@2.0.2/dist/webauthn-json.browser-ponyfill.min.js"></script>
  <script>
    const biometricBtn = document.getElementById('biometric-login-btn');
    biometricBtn?.addEventListener('click', async function () {
      try {
        const res = await fetch("{{ route('user.webauthn.options') }}", {
          method: 'GET',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        });

        if (!res.ok) throw new Error('Gagal mendapatkan opsi autentikasi.');

        const options = await res.json();
        const { startAuthentication } = window['@github/webauthn-json'];
        const credential = await startAuthentication(options);

        const form = document.getElementById('webauthn-login-form');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'credential';
        input.value = JSON.stringify(credential);
        form.appendChild(input);
        form.submit();

      } catch (error) {
        alert("Login biometrik gagal: " + error.message);
      }
    });
  </script>
</body>
</html>