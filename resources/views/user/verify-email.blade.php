<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verifikasi Email</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />
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
            background: url('/images/caffeshop.jpg') no-repeat center center;
            background-size: cover;
            color: #fff;
        }
        .wrapper {
            width: 400px;
            background: rgba(0,0,0,0.5);
            border: 2px solid #000;
            border-radius: 15px;
            padding: 30px 40px;
            text-align: center;
            box-shadow: 0 0 10px #000;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 25px;
            font-size: 16px;
            line-height: 1.4;
        }
        form button {
            width: 100%;
            height: 50px;
            background: #000;
            border: none;
            border-radius: 40px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        form button:hover {
            background: #333;
        }
        .message {
            margin-bottom: 15px;
            color: #00ff00;
        }
        a.logout-link {
            display: inline-block;
            margin-top: 15px;
            color: #fff;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1>Verifikasi Email</h1>

        @if (session('message'))
            <div class="message">{{ session('message') }}</div>
        @endif

        <p>
            Terima kasih sudah mendaftar! Sebelum melanjutkan, silakan cek email kamu dan klik link verifikasi yang kami kirimkan.
            Jika kamu tidak menerima email, kamu bisa klik tombol di bawah untuk mengirim ulang link verifikasi.
        </p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">Kirim Ulang Email Verifikasi</button>
        </form>

        <form method="POST" action="{{ route('user.logout') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" style="background:#ff4d4d;">Logout</button>
        </form>
    </div>
</body>
</html>
