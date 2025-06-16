@extends('layout.main')

@section('title', 'Edit category')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Edit category</h5>
    <p class="card-description">Perbarui detail category pada formulir berikut.</p>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('category.update', $category->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')

      <div class="row mb-4">
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label">Nama category</label>
          <input type="text" id="name" name="name" class="form-control"
            value="{{ old('name', $category->name) }}" required>
        </div>

         <div class="d-flex gap-3">
        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
        <a href="{{ route('category.index') }}" class="btn btn-secondary w-100">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
