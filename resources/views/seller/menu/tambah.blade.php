@extends('layout.main')

@section('title', 'Tambah Menu')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Tambah Menu Baru</h5>
    <p class="card-description">Halaman ini memungkinkan admin untuk menambahkan Menu baru ke sistem</p>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data" id="menu-form">
      @csrf

      <div class="row mb-4">
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label">Nama Menu</label>
          <input type="text" class="form-control" id="name" name="name"
            value="{{ old('name', $_POST['name'] ?? '') }}" placeholder="Masukkan nama menu" required>
        </div>

        <div class="col-md-6 mb-3">
          <label for="category_id" class="form-label">Kategori</label>
          <select class="form-select" id="category_id" name="category_id" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($category as $c)
              <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6 mb-3">
          <label for="price" class="form-label">Harga (Rp)</label>
          <input type="number" class="form-control" id="price" name="price" min="0"
            value="{{ old('price', $_POST['price'] ?? '') }}" placeholder="Masukkan harga" required>
        </div>

        <div class="col-md-6 mb-3">
          <label for="stock" class="form-label">Stok</label>
          <input type="number" class="form-control" id="stock" name="stock" min="0"
            value="{{ old('stock', $_POST['stock'] ?? '') }}" placeholder="Masukkan jumlah stok" required>
        </div>

        <div class="col-12 mb-3">
          <label for="description" class="form-label">Deskripsi</label>
          <textarea class="form-control" id="description" name="description" rows="4"
            placeholder="Masukkan deskripsi menu" required>{{ old('description', $_POST['description'] ?? '') }}</textarea>
        </div>

        <div class="col-12 mb-3">
          <label for="image" class="form-label">Gambar</label>
          <input type="file" class="form-control" id="image" name="image" accept="image/*">
          <small class="text-muted">Format: JPG, PNG, GIF. Ukuran maksimal: 2MB</small>
        </div>
      </div>

      <div class="d-flex gap-3">
        <button type="submit" class="btn btn-primary w-100">Simpan Menu</button>
        <a href="{{route('menu.index')}}" class="btn btn-secondary w-100">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
