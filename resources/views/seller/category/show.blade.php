@extends('layout.main')

@section('title', 'Edit category')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Detail category</h5>
    <p class="card-description">Lihat detail category berikut.</p>

    <div class="row mb-4">
      <div class="col-md-6 mb-3">
        <label for="name" class="form-label">Nama ketegori</label>
        <input type="text" id="name" class="form-control" value="{{ old('name', $category->name) }}" disabled>
      </div>


    <div class="d-flex justify-content-end">
      <a href="{{ route('category.index') }}" class="btn btn-primary">Kembali</a>
    </div>
  </div>
</div>
@endsection
