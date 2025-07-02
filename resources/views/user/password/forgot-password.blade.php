<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
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
            position: relative;
        }

        .wrapper h1 {
            font-size: 30px;
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
</head>
<body>
    <div class="wrapper">
        <form id="forgotPasswordForm" action="forgot_password.php" method="POST">
            <h1>Forgot Password</h1>
            <p style="text-align: center; margin-bottom: 15px;">Masukkan email Anda untuk menerima instruksi reset password.</p>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class="ri-mail-line"></i>
            </div>
            <button type="submit" class="btn">Kirim</button>
            <div class="register-link">
                <p>Sudah ingat password? <a href="{{ route('user.login') }}" class="btn-login">Login</a>
            </div>
        </form>
    </div>
</body>
</html>
