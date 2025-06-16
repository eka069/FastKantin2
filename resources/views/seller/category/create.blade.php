@extends('layout.main')

@section('title', 'Tambah category')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Tambah Category Baru</h5>
    <p class="card-description">Halaman ini memungkinkan admin untuk menambahkan Category baru ke sistem</p>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data" id="category-form">
      @csrf

      <div class="row mb-4">
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label">Nama category</label>
          <input type="text" class="form-control" id="name" name="name"
            value="{{ old('name', $_POST['name'] ?? '') }}" placeholder="Masukkan nama category" required>
        </div>
      <div class="d-flex gap-3">
        <button type="submit" class="btn btn-primary w-100">Simpan category</button>
        <a href="{{route('category.index')}}" class="btn btn-secondary w-100">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
