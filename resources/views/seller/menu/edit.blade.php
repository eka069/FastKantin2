@extends('layout.main')

@section('title', 'Edit Menu')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Edit Menu</h5>
    <p class="card-description">Perbarui detail menu pada formulir berikut.</p>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('menu.update', $menu->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')

      <div class="row mb-4">
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label">Nama Menu</label>
          <input type="text" id="name" name="name" class="form-control"
            value="{{ old('name', $menu->name) }}" required>
        </div>

        <div class="col-md-6 mb-3">
          <label for="category_id" class="form-label">Kategori</label>
          <select id="category_id" name="category_id" class="form-select" required>
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
          <input type="number" id="price" name="price" min="0" class="form-control"
            value="{{ old('price', $menu->price) }}" required>
        </div>

        <div class="col-md-6 mb-3">
          <label for="stock" class="form-label">Stok</label>
          <input type="number" id="stock" name="stock" min="0" class="form-control"
            value="{{ old('stock', $menu->stock) }}" required>
        </div>

        <div class="col-12 mb-3">
          <label for="description" class="form-label">Deskripsi</label>
          <textarea id="description" name="description" rows="4" class="form-control" required>{{ old('description', $menu->description) }}</textarea>
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
          <input type="file" id="image" name="image" accept="image/*" class="form-control">
          <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
        </div>
      </div>

      <div class="d-flex gap-3">
        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
        <a href="{{ route('menu.index') }}" class="btn btn-secondary w-100">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
