@extends('layouts.seller')

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <h2>Edit Produk</h2>
        <a href="{{ route('seller.products.index') }}" style="color: #666; text-decoration: none;">&larr; Kembali ke Daftar</a>
    </div>

    <div class="card" style="max-width: 600px;">
        <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', (int)$product->price) }}" required min="0">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Foto Produk (Biarkan kosong jika tidak ingin mengubah)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                @if($product->image)
                    <div style="margin-top: 1rem;">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Current Photo" style="width: 100px; border-radius: 8px;">
                    </div>
                @endif
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
