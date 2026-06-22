<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller Dashboard - Ayam Kampus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #E53935;
            --secondary: #FF5FA2;
            --background: #f4f6f9;
            --sidebar: #ffffff;
            --text-dark: #333333;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }
        a, button, .card { transition: all 0.3s ease-in-out; }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar);
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
            transition: transform 0.3s;
        }
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .sidebar-header h2 {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 800;
        }
        .close-sidebar {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
            color: #666;
        }
        .sidebar-menu {
            flex: 1;
            padding: 1rem 0;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .sidebar-link {
            padding: 1rem 1.5rem;
            color: #555;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-left: 4px solid transparent;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(229, 57, 53, 0.05);
            color: var(--primary);
            border-left-color: var(--primary);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            width: calc(100% - 260px);
            transition: margin-left 0.3s;
        }
        .topbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 90;
        }
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 4px;
            cursor: pointer;
        }
        .hamburger span {
            width: 25px;
            height: 3px;
            background: var(--text-dark);
            border-radius: 5px;
        }
        .content-area {
            padding: 2rem;
            flex: 1;
            overflow-x: hidden;
        }

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            .hamburger { display: flex; }
            .close-sidebar { display: block; }
            .topbar { padding: 1rem; }
            .content-area { padding: 1rem; }
        }

        /* Form & Cards */
        .card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            margin-bottom: 1.5rem;
        }
        .card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.06); }
        
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            display: inline-block;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        
        .btn-primary { background: var(--primary); color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s;
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(229,57,53,0.1); }
        
        /* Table Responsive */
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        table th, table td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
        
        /* Toast Alert */
        .toast-alert {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            animation: slideIn 0.5s ease-out forwards, fadeOut 0.5s ease-in forwards 4s;
            z-index: 9999;
        }
        .toast-success { background: #28a745; }
        .toast-error { background: #dc3545; }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; visibility: hidden; }
        }
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>🍗 Ayam Kampus</h2>
            <div class="close-sidebar" onclick="document.getElementById('sidebar').classList.remove('active')">&times;</div>
        </div>
        <nav class="sidebar-menu">
            <a href="{{ route('seller.dashboard') }}" class="sidebar-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('seller.products.index') }}" class="sidebar-link {{ request()->routeIs('seller.products.*') ? 'active' : '' }}">Produk</a>
            <a href="#" class="sidebar-link" onclick="alert('Menu Promo segera hadir')">Promo</a>
            <a href="#" class="sidebar-link" onclick="alert('Menu Pesanan segera hadir')">Pesanan</a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link">Profil</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div class="hamburger" onclick="document.getElementById('sidebar').classList.toggle('active')">
                <span></span><span></span><span></span>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem; margin-left: auto;">
                <span style="font-weight: 600;">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="font-family: 'Inter', sans-serif;">Logout</button>
                </form>
            </div>
        </header>

        <div class="content-area">
            @if(session('success'))
                <div class="toast-alert toast-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="card" style="background: #fff3f3; border-left: 5px solid #dc3545; color: #dc3545;">
                    <ul style="margin-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

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
