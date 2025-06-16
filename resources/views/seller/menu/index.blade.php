@extends('layout.main')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Daftar Menu Makanan </h5>
        <p>Menu Makanan  memungkinkan admin untuk mengelola, memantau, dan memperbarui informasi daftar menu makanan secara efisien</p>

        <a href="{{route('menu.create')}}" class="btn btn-success btn-sm mb-4">
            <i class="fas fa-plus"></i> Tambah
        </a>


        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <table id="zero-conf" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>category</th>
                    <th>price</th>
                    <th>Stock</th>
                    <th>desc</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($menu as $m)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$m -> name}}</td>
                        <td>{{$m -> category -> name}}</td>
                        <td>{{$m -> price}}</td>
                        <td>{{$m -> stock}}</td>
                        <td>{{$m -> description}}</td>
                        <td class="d-flex">
                            <a href="{{route('menu.edit', $m->id)}}" class="btn btn-warning btn-sm ">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{route('menu.show', $m->id)}}" class="btn btn-info btn-sm mx-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $m->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
            <tfoot>
                <tr>
                   <th>No</th>
                    <th>Name</th>
                    <th>category</th>
                    <th>price</th>
                    <th>Stock</th>
                    <th>desc</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@push('custom-style')
<link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
<link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/font-awesome/css/all.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/perfectscroll/perfect-scrollbar.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/DataTables/datatables.min.css')}}" rel="stylesheet">

<!-- Theme Styles -->
<link href="{{asset('assets/css/main.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">
@endpush

@push('custom-scripts')
<!-- Javascripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let menuId = $(this).data('id');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('menu') }}/" + menuId,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire('Dihapus!', 'Data berhasil dihapus.', 'success')
                            .then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Gagal!', 'Terjadi kesalahan, coba lagi nanti.', 'error');
                    }
                });
            }
        });
    });
</script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endpush
