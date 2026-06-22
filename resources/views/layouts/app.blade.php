<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ayam Kampus - App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #E53935;
            --secondary: #FF5FA2;
            --background: #fcfcfc;
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
        a, button, .card, .btn {
            transition: all 0.3s ease-in-out;
        }
        /* Navbar */
        .navbar {
            background-color: var(--primary);
            color: var(--text-light);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(229, 57, 53, 0.2);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar .logo {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-decoration: none;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .nav-links { 
            display: flex; 
            gap: 1.5rem; 
            align-items: center; 
        }
        .nav-links a {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-links a:hover { color: var(--secondary); }
        .btn-login {
            background: white;
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.9rem;
        }
        .btn-login:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            background: var(--text-light);
            color: var(--primary);
        }

        /* Mobile Hamburger */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
        }
        .hamburger span {
            width: 25px;
            height: 3px;
            background: white;
            border-radius: 5px;
            transition: all 0.3s;
        }

        /* Media Query for Mobile Nav */
        @media (max-width: 768px) {
            .navbar { padding: 1rem; }
            .hamburger { display: flex; }
            .nav-links {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: var(--primary);
                flex-direction: column;
                align-items: flex-start;
                padding: 1rem 2rem;
                gap: 1rem;
                box-shadow: 0 4px 12px rgba(229, 57, 53, 0.2);
                transform: translateY(-150%);
                opacity: 0;
                pointer-events: none;
                transition: all 0.3s ease-in-out;
            }
            .nav-links.active {
                transform: translateY(0);
                opacity: 1;
                pointer-events: auto;
            }
            .nav-links form { width: 100%; }
            .btn-login { width: 100%; text-align: center; display: block; }
        }

        /* Main Content */
        .content {
            flex: 1;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }
        @media (max-width: 768px) {
            .content { padding: 1rem; }
        }

        /* Footer */
        .footer {
            background-color: var(--text-dark);
            color: var(--text-light);
            text-align: center;
            padding: 2rem;
            margin-top: auto;
        }
        .footer p { margin-bottom: 0.5rem; }
        .footer .highlight { color: var(--secondary); font-weight: bold; }
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
            <a href="{{ route('promo.index') }}" style="color: #ffeeb2; font-weight: bold;">Promo 🔥</a>
            @auth
                <a href="{{ route('orders.index') }}">Pesanan Saya</a>
                <a href="{{ route('profile.edit') }}">Profil</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-login" style="border:none; cursor:pointer; font-family: 'Inter', sans-serif;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login" style="font-family: 'Inter', sans-serif;">Masuk / Daftar</a>
            @endauth
        </div>
    </nav>

    @isset($header)
        <header class="bg-white shadow" style="padding: 1rem 2rem; margin-bottom: 1rem; border-bottom: 2px solid #eee;">
            {{ $header }}
        </header>
    @endisset

    <main class="content">
        {!! $slot ?? '' !!}
        @yield('content')
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Ayam Kampus. Hak Cipta Dilindungi.</p>
        <p>Marketplace Kuliner Mahasiswa <span class="highlight">Terbaik</span></p>
    </footer>

    <script>
        // Global Submit Button Loading State
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
