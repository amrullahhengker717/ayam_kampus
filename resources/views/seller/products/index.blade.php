@extends('layouts.seller')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2>Daftar Produk</h2>
        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div style="width: 50px; height: 50px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center;">🍗</div>
                            @endif
                        </td>
                        <td style="font-weight: 600;">{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('seller.products.edit', $product->id) }}" class="btn btn-secondary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">Edit</a>
                            <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem;">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="margin-top: 1rem;">
            {{ $products->links() }}
        </div>
    </div>
@endsection
