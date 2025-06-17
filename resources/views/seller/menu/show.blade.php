@extends('layout.main')

@section('title', 'Edit Menu')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Detail Menu</h5>
    <p class="card-description">Lihat detail menu berikut.</p>

    <div class="row mb-4">
      <div class="col-md-6 mb-3">
        <label for="name" class="form-label">Nama Menu</label>
        <input type="text" id="name" class="form-control" value="{{ old('name', $menu->name) }}" disabled>
      </div>

      <div class="col-md-6 mb-3">
        <label for="category_id" class="form-label">Kategori</label>
        <select id="category_id" class="form-select" disabled>
          <option value="">Pilih kategori</option>
          @foreach ($category as $c)
            <option value="{{ $c->id }}" {{ old('category_id', $menu->category_id) == $c->id ? 'selected' : '' }}>
              {{ $c->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6 mb-3">
        <label for="price" class="form-label">Harga (Rp)</label>
        <input type="number" id="price" class="form-control" value="{{ old('price', $menu->price) }}" disabled>
      </div>

      <div class="col-md-6 mb-3">
        <label for="stock" class="form-label">Stok</label>
        <input type="number" id="stock" class="form-control" value="{{ old('stock', $menu->stock) }}" disabled>
      </div>

      <div class="col-12 mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea id="description" rows="4" class="form-control" disabled>{{ old('description', $menu->description) }}</textarea>
      </div>

      @if ($menu->image)
        <div class="col-12 mb-3">
          <label class="form-label">Gambar Saat Ini</label>
          <div class="w-25 rounded overflow-hidden border">
            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="img-fluid">
          </div>
        </div>
      @endif

      <div class="col-12 mb-3">
        <label for="image" class="form-label">Gambar Baru (Opsional)</label>
        <input type="file" id="image" name="image" accept="image/*" class="form-control" disabled>
        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <a href="{{ route('menu.index') }}" class="btn btn-primary">Kembali</a>
    </div>
  </div>
</div>
@endsection
