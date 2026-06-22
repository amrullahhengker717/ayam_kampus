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
        <a href="{{ route('booking.create', $product->id) }}" class="btn-book" style="display: block; text-align: center; text-decoration: none;">Booking Sekarang</a>
    </div>
</div>
@endforeach
