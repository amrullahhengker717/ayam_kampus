@extends('layouts.app')

@section('content')
<style>
    .home-container {
        display: flex;
        flex-direction: column;
        gap: 3rem;
        padding-bottom: 3rem;
    }

    /* Search Bar */
    .search-section {
        background: linear-gradient(135deg, rgba(229, 57, 53, 0.05), rgba(255, 95, 162, 0.1));
        padding: 3rem 2rem;
        border-radius: 20px;
        text-align: center;
    }
    .search-section h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        color: var(--text-dark);
    }
    .search-form {
        display: flex;
        max-width: 600px;
        margin: 0 auto;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-radius: 50px;
        overflow: hidden;
    }
    .search-input {
        flex: 1;
        padding: 1rem 1.5rem;
        border: none;
        outline: none;
        font-size: 1.1rem;
    }
    .search-btn {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        padding: 1rem 2rem;
        font-weight: bold;
        cursor: pointer;
        transition: opacity 0.3s;
    }
    .search-btn:hover { opacity: 0.9; }

    /* Banner Promo */
    .promo-section {
        overflow-x: auto;
        display: flex;
        gap: 1.5rem;
        padding: 1rem 0;
        scrollbar-width: none; /* Firefox */
    }
    .promo-section::-webkit-scrollbar { display: none; /* Chrome */ }
    .promo-card {
        min-width: 300px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(229, 57, 53, 0.2);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .promo-title { font-size: 1.2rem; font-weight: 800; margin-bottom: 0.5rem; }
    .promo-discount { font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem; }
    .promo-product { opacity: 0.9; font-size: 0.9rem; }

    /* Kategori Horizontal */
    .category-scroll {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding: 0.5rem 0;
        scrollbar-width: none;
    }
    .category-scroll::-webkit-scrollbar { display: none; }
    .category-pill {
        background: white;
        border: 1px solid #ddd;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        white-space: nowrap;
        font-weight: 600;
        color: var(--text-dark);
        text-decoration: none;
        transition: all 0.3s;
    }
    .category-pill:hover, .category-pill.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    /* Product Feed */
    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
    }
    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid #eee;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .product-img-wrapper {
        height: 180px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-placeholder {
        font-size: 4rem;
        filter: drop-shadow(0 5px 5px rgba(0,0,0,0.1));
    }
    .product-info {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .product-category {
        color: var(--secondary);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }
    .product-name {
        font-size: 1.1rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }
    .product-seller {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 1rem;
    }
    .product-price {
        font-size: 1.3rem;
        font-weight: 900;
        color: var(--primary);
        margin-bottom: 1.5rem;
        margin-top: auto;
    }
    .btn-book {
        width: 100%;
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
        padding: 0.8rem;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-book:hover {
        background: var(--primary);
        color: white;
    }

    /* Infinite Scroll Loader */
    .loader {
        text-align: center;
        padding: 2rem;
        color: #888;
        font-weight: bold;
        display: none;
    }
</style>

<div class="home-container">

    <!-- Search Section -->
    <div class="search-section">
        <h2>Mau makan apa hari ini?</h2>
        <form action="{{ route('home') }}" method="GET" class="search-form">
            <input type="text" name="search" value="{{ $search ?? '' }}" class="search-input" placeholder="Cari ayam geprek, nasi goreng, dll...">
            <button type="submit" class="search-btn">Cari</button>
        </form>
    </div>

    <!-- Banner Promo -->
    @if($promos->count() > 0)
    <div>
        <h3 class="section-title">🔥 Promo Spesial</h3>
        <div class="promo-section">
            @foreach($promos as $promo)
            <div class="promo-card">
                <div class="promo-title">{{ $promo->title }}</div>
                <div class="promo-discount">{{ $promo->discount_percentage }}% OFF</div>
                <div class="promo-product">{{ $promo->product->name ?? 'Produk Terpilih' }} - {{ $promo->product->seller->store_name ?? '' }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Kategori Horizontal -->
    <div>
        <h3 class="section-title">🍔 Kategori</h3>
        <div class="category-scroll">
            <a href="{{ route('home') }}" class="category-pill {{ empty($search) ? 'active' : '' }}">Semua</a>
            @foreach($categories as $category)
            <a href="#" class="category-pill" onclick="alert('Filter kategori akan segera hadir!')">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>

    <!-- Product Feed -->
    <div>
        <h3 class="section-title">✨ Rekomendasi Untukmu</h3>
        
        @if($products->count() > 0)
            <div class="product-grid" id="product-container">
                @include('components.product-list', ['products' => $products])
            </div>
            <div class="loader" id="loader">Memuat produk lainnya... 🍗</div>
        @else
            <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <span style="font-size: 4rem; display: block; margin-bottom: 1rem;">🍽️</span>
                <h3 style="color: #555; margin-bottom: 0.5rem;">Maaf, menu belum tersedia.</h3>
                <p style="color: #888;">Coba cari dengan kata kunci lain atau cek lagi nanti!</p>
            </div>
        @endif
    </div>

</div>

<!-- Infinite Scroll Logic -->
<script>
    let page = 1;
    let isLoading = false;
    let hasMorePages = {{ $products->hasMorePages() ? 'true' : 'false' }};
    
    window.addEventListener('scroll', () => {
        if (isLoading || !hasMorePages) return;
        
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
            loadMoreProducts();
        }
    });

    function loadMoreProducts() {
        isLoading = true;
        page++;
        document.getElementById('loader').style.display = 'block';

        let url = new URL(window.location.href);
        url.searchParams.set('page', page);

        fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(response => response.text())
        .then(html => {
            if (html.trim() === '') {
                hasMorePages = false;
                document.getElementById('loader').innerText = 'Semua produk telah ditampilkan.';
            } else {
                document.getElementById('product-container').insertAdjacentHTML('beforeend', html);
            }
            isLoading = false;
            if(hasMorePages) {
                document.getElementById('loader').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error loading more products:', error);
            isLoading = false;
            document.getElementById('loader').style.display = 'none';
        });
    }
</script>
@endsection
