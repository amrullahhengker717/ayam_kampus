<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ayam Kampus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #E53935;
            --secondary: #FF5FA2;
            --background: #FFFFFF;
            --text-dark: #333333;
            --text-light: #F5F5F5;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--background);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }
        a, button, input { transition: all 0.3s; }
        
        /* Navbar */
        .navbar {
            background-color: transparent;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 100;
        }
        .navbar .logo {
            font-size: 1.5rem;
            font-weight: 800;
            text-decoration: none;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .navbar .nav-links { display: flex; gap: 1.5rem; align-items: center; }
        .navbar .nav-links a {
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
        }
        .navbar .nav-links a:hover { color: var(--primary); }
        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white !important;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: bold !important;
            box-shadow: 0 4px 15px rgba(229, 57, 53, 0.3);
            text-decoration: none;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(229, 57, 53, 0.4);
        }

        /* Mobile Hamburger */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            background: var(--primary);
            padding: 8px;
            border-radius: 8px;
        }
        .hamburger span {
            width: 20px;
            height: 2px;
            background: white;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .navbar { padding: 1rem; }
            .hamburger { display: flex; }
            .nav-links {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: white;
                flex-direction: column;
                align-items: center;
                padding: 1.5rem;
                gap: 1rem;
                box-shadow: 0 10px 15px rgba(0,0,0,0.05);
                transform: translateY(-150%);
                opacity: 0;
                pointer-events: none;
            }
            .nav-links.active {
                transform: translateY(0);
                opacity: 1;
                pointer-events: auto;
            }
        }

        /* Main Content */
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 6rem 1rem 2rem;
            width: 100%;
        }

        /* Form Card Specific Polishing */
        .content > div {
            width: 100%;
            max-width: 400px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
            border-radius: 20px !important;
            padding: 2.5rem !important;
            background: white !important;
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Footer */
        .footer {
            background-color: var(--background);
            color: var(--text-dark);
            text-align: center;
            padding: 1.5rem;
            border-top: 1px solid #eee;
            margin-top: auto;
        }
        .footer p { font-size: 0.9rem; color: #666; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="/" class="logo">
            🍗 Ayam Kampus
        </a>
        <div class="hamburger" onclick="document.querySelector('.nav-links').classList.toggle('active')">
            <span></span><span></span><span></span>
        </div>
        <div class="nav-links">
            <a href="/">Beranda</a>
            <a href="/home">Menu</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-login">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-login" style="background: white; color: var(--primary) !important; border: 2px solid var(--primary); box-shadow: none;">Daftar</a>
                @endif
            @endauth
        </div>
    </nav>

    <main class="content">
        {!! $slot ?? '' !!}
        @yield('content')
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Ayam Kampus. Marketplace Kuliner Pilihan Kampus.</p>
    </footer>

    <script>
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const btn = this.querySelector('button[type="submit"]');
                if(btn && !btn.classList.contains('no-loading')) {
                    btn.dataset.originalText = btn.innerHTML;
                    btn.innerHTML = 'Memproses...';
                    btn.style.opacity = '0.7';
                    btn.style.pointerEvents = 'none';
                }
            });
        });
    </script>
</body>
</html>
