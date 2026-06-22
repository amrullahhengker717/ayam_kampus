@foreach($products as $product)
<div class="product-card">
    <div class="product-img-wrapper">
        <div class="product-placeholder">
            @php
                $icons = ['🍔', '🍗', '🍜', '🍕', '🍱', '☕', '🍛'];
                echo $icons[array_rand($icons)];
            @endphp
        </div>
    </div>
    <div class="product-info">
        <div class="product-category">{{ $product->category->name ?? 'Kategori' }}</div>
        <h3 class="product-name">{{ $product->name }}</h3>
        <p class="product-seller">Oleh: <strong>{{ $product->seller->store_name ?? 'Penjual' }}</strong></p>
        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
        <button class="btn-book" onclick="alert('Fitur booking akan segera hadir!')">Booking Sekarang</button>
    </div>
</div>
@endforeach
