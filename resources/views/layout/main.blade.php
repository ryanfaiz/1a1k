<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? '1ToKnow1ToAsk - Learning Platform' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
        }


        /* Animated Background */
            body::before {
    content: "";
    position: fixed;
    inset: 0;
    background-image:
        radial-gradient(circle at 1px 1px, rgba(255,255,255,0.06) 1px, transparent 1px);
    background-size: 30px 30px;
    pointer-events: none;
    z-index: 0;
}


        body::after {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -200px;
            left: -100px;
            animation: float 10s ease-in-out infinite reverse;
            z-index: 0;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-30px) rotate(10deg);
            }
        }

        /* Navbar Styling */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem !important;
            position: sticky;
            top: 0;
            z-index: 1000;
            
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
                color: #37406E !important;
            font-weight: 700;
            letter-spacing: 0.5px;
            }
            .navbar-brand:hover {
                color: #5F6F92 !important;
            }

        .navbar a:not(.navbar-brand):not(.btn) {
            color: #333 !important;
            font-weight: 600;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar a:not(.navbar-brand):not(.btn):hover {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            color: #667eea !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8798e0ff 0%, #7f609eff 100%) !important;
            border: none !important;
            padding: 0.5rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-outline-danger {
            background: transparent !important;
            border: 2px solid #ef4444 !important;
            color: #ef4444 !important;
            padding: 0.5rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            background: #ef4444 !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.3);
        }

        .user-profile {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            padding: 0.5rem 1rem;
            border-radius: 10px;
            color: #333 !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .user-profile:hover {
            background: linear-gradient(135deg, #667eea25 0%, #764ba225 100%);
            transform: translateY(-2px);
        }

        /* Container */
        .container {
            position: relative;
            z-index: 10;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .welcome-card h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .welcome-card p {
            color: #666;
            font-size: 1.1rem;
        }

        /* Stats Cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;      /* Tengah horizontal */
            justify-content: center;  /* Tengah vertikal */
            text-align: center;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
            color: #667eea;
        }

        .stat-card:nth-child(2) .stat-icon {
            background: linear-gradient(135deg, #4facfe20 0%, #00f2fe20 100%);
            color: #4facfe;
        }


        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
            text-align: center;
        }

        .stat-label {
            color: #666;
            font-size: 0.95rem;
            font-weight: 500;
             margin-top: 5px;
            opacity: 0.8;
        }

        /* Content Cards */
        .content-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .content-card h3 {
            color: #333;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .content-card h3::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }

        /* Quick Action Buttons */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .action-btn {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border: 2px solid transparent;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            color: #333;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .action-btn:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .action-btn-icon {
            font-size: 32px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-card h1 {
                font-size: 2rem;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }

            .navbar {
                padding: 1rem !important;
            }
        }

        /* Table */
        table.table {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            overflow: hidden;
            border: none !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        table.table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }

        table.table th,
        table.table td {
            padding: 14px 16px !important;
            vertical-align: middle;
        }

        table.table tbody tr:hover {
            background: rgba(102, 126, 234, 0.08);
            transition: 0.2s ease;
        }

        table.table tbody tr td {
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
    </style>
</head>
<body class="bg-light">

    <!-- HEADER -->
    <nav class="navbar navbar-light bg-white shadow-sm px-3">
        <a href="/" class="navbar-brand mb-0 h4">1ToAsk1ToKnow</a>

        <!-- MENU NAVIGASI -->
        <a href="{{ route('courses.index') }}" class="text-decoration-none">📚Materi</a>
        <a href="/qna" class="text-decoration-none">💬Q&A</a>

        <div class="d-flex align-items-center gap-3">

            <!-- KONDISI LOGIN -->
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
            @endguest

            @auth
                    <a href="/profile" class="text-decoration-none">
                        {{ auth()->user()->name }}
                    </a>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.users.index') }}" class="ms-3 text-decoration-none">Users</a>
                    @endif

                <form action="/logout" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm" type="submit">Logout</button>
                </form>
            @endauth
        </div>
    </nav>

   <div class="container py-4">

    @yield('content')

</div>

@yield('scripts')
</body>
</html>
