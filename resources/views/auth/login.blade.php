<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - 1ToAsk1ToKnow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 40px 0;
        }

        /* Animated background circles */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            animation: float 6s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -150px;
            left: -150px;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-20px) scale(1.05);
            }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 50px 40px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
            }
        }

        .logo-icon svg {
            width: 40px;
            height: 40px;
            fill: white;
        }

        .logo-section h1 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .logo-section p {
            color: #666;
            font-size: 14px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: white;
            outline: none;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
            color: #999;
            font-size: 14px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }

        .divider span {
            padding: 0 15px;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .register-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #764ba2;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin: 15px 0;
        }

        .checkbox-container input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .checkbox-container label {
            font-size: 14px;
            color: #666;
            cursor: pointer;
            margin: 0;
        }

        .forgot-password {
            text-align: right;
            margin-top: 10px;
        }

        .forgot-password a {
            color: #667eea;
            font-size: 13px;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .back-home {
            text-align: center;
            margin-top: 25px;
        }

        .back-home a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .back-home a:hover {
            color: #764ba2;
            gap: 8px;
        }

        .alert {
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 40px 30px;
            }
            
            .logo-section h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V7.89l7-3.11v8.2z"/>
                    </svg>
                </div>
                <h1>1ToAsk1ToKnow</h1>
                <p>Selamat datang kembali! Silakan login ke akun Anda</p>
            </div>

            <!-- Alert Error (Hidden by default, show when error exists) -->
            <!-- <div class="alert alert-danger">
                Email atau password salah!
            </div> -->

            <form action="/login" method="POST">
                <!-- CSRF Token for Laravel -->
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="nama@example.com" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                </div>

                <button type="submit" class="btn-login">Masuk</button>

                <div class="divider">
                    <span>atau</span>
                </div>

                <div class="register-link">
                    Belum punya akun? <a href="/register">Daftar sekarang</a>
                </div>

                <div class="back-home">
                    <a href="/">
                        <span>←</span>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
