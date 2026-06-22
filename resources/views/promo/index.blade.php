@extends('layouts.app')

@section('content')
<style>
    .promo-container {
        max-width: 1200px;
        margin: 0 auto 3rem;
    }
    .filter-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }
    .filter-tab {
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        background: white;
        color: #555;
        text-decoration: none;
        font-weight: 600;
        white-space: nowrap;
        border: 1px solid #ddd;
        transition: all 0.2s;
    }
    .filter-tab:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    .filter-tab.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    .promo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }
    .promo-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        position: relative;
        transition: transform 0.3s;
    }
    .promo-card:hover {
        transform: translateY(-5px);
    }
    .promo-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--secondary);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 800;
        font-size: 1.2rem;
        z-index: 10;
        box-shadow: 0 4px 10px rgba(255, 95, 162, 0.4);
    }
    .promo-img-container {
        height: 180px;
        width: 100%;
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .promo-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .promo-content {
        padding: 1.5rem;
    }
    .promo-title {
        font-size: 1.2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }
    .original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 0.9rem;
    }
    .discount-price {
        font-size: 1.4rem;
        font-weight: 900;
        color: var(--primary);
    }
    .countdown-box {
        background: #fff3cd;
        border: 1px solid #ffeeba;
        color: #856404;
        padding: 0.8rem;
        border-radius: 8px;
        text-align: center;
        font-weight: 700;
        margin-top: 1rem;
        font-size: 0.9rem;
    }
    .countdown-value {
        font-variant-numeric: tabular-nums;
    }
    .btn-claim {
        display: block;
        width: 100%;
        text-align: center;
        background: var(--primary);
        color: white;
        padding: 0.8rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        margin-top: 1rem;
        transition: background 0.3s;
    }
    .btn-claim:hover {
        background: #c62828;
    }
</style>

<div class="promo-container">
    <h2 style="margin-bottom: 0.5rem; font-size: 2rem;">Promo Menarik 🔥</h2>
    <p style="color: #666; margin-bottom: 2rem;">Jangan sampai kehabisan diskon makanan favoritmu!</p>

    <!-- Filters -->
    <div class="filter-tabs">
        <a href="{{ route('promo.index', ['filter' => 'terbaru']) }}" class="filter-tab {{ (request('filter') == 'terbaru' || !request('filter')) ? 'active' : '' }}">Terbaru</a>
        <a href="{{ route('promo.index', ['filter' => 'diskon_terbesar']) }}" class="filter-tab {{ request('filter') == 'diskon_terbesar' ? 'active' : '' }}">Diskon Terbesar</a>
        <a href="{{ route('promo.index', ['filter' => 'akan_berakhir']) }}" class="filter-tab {{ request('filter') == 'akan_berakhir' ? 'active' : '' }}">Akan Berakhir</a>
    </div>

    <!-- Promo Grid -->
    <div class="promo-grid">
        @forelse($promos as $promo)
            @php
                $product = $promo->product;
                if(!$product) continue;
                $originalPrice = $product->price;
                $discountPrice = $originalPrice - ($originalPrice * ($promo->discount_percentage / 100));
            @endphp
            <div class="promo-card">
                <div class="promo-badge">{{ (int)$promo->discount_percentage }}% OFF</div>
                <div class="promo-img-container">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <span style="font-size: 4rem;">🎁</span>
                    @endif
                </div>
                <div class="promo-content">
                    <div style="font-size: 0.8rem; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.3rem;">
                        {{ $product->seller->store_name ?? 'Penjual' }}
                    </div>
                    <h3 class="promo-title">{{ $promo->title }}</h3>
                    <div style="margin-bottom: 0.5rem;">
                        <span class="original-price">Rp {{ number_format($originalPrice, 0, ',', '.') }}</span>
                        <div class="discount-price">Rp {{ number_format($discountPrice, 0, ',', '.') }}</div>
                    </div>
                    
                    <div class="countdown-box" data-end="{{ \Carbon\Carbon::parse($promo->end_date)->endOfDay()->toIso8601String() }}">
                        Berakhir dalam: <span class="countdown-value">Menghitung...</span>
                    </div>

                    @auth
                        <a href="{{ route('booking.create', $product->id) }}" class="btn-claim">Klaim Promo</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-claim">Login untuk Klaim</a>
                    @endauth
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: white; border-radius: 15px;">
                <span style="font-size: 4rem; display: block; margin-bottom: 1rem;">😢</span>
                <h3 style="color: #555; margin-bottom: 0.5rem;">Yah, belum ada promo aktif saat ini.</h3>
                <p style="color: #888;">Cek lagi nanti ya untuk mendapatkan penawaran spesial!</p>
            </div>
        @endforelse
    </div>
    
    <div style="margin-top: 2rem;">
        {{ $promos->appends(request()->query())->links() }}
    </div>
</div>

<script>
    function updateCountdowns() {
        const boxes = document.querySelectorAll('.countdown-box');
        const now = new Date().getTime();

        boxes.forEach(box => {
            const endDateStr = box.getAttribute('data-end');
            const targetDate = new Date(endDateStr).getTime();
            const distance = targetDate - now;

            const valueSpan = box.querySelector('.countdown-value');

            if (distance < 0) {
                valueSpan.innerHTML = "Berakhir";
                box.style.background = '#f8d7da';
                box.style.color = '#721c24';
                box.style.borderColor = '#f5c6cb';
            } else {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                let displayStr = "";
                if(days > 0) displayStr += days + "h ";
                displayStr += hours + "j " + minutes + "m " + seconds + "d";
                
                valueSpan.innerHTML = displayStr;
            }
        });
    }

    setInterval(updateCountdowns, 1000);
    updateCountdowns(); // Initial call
</script>
@endsection
