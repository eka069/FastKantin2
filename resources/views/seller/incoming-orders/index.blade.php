@extends('layout.main')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Daftar Pesanan Masuk</h5>
        <p>Pesanan masuk memungkinkan admin untuk memantau dan mengelola daftar pesanan yang telah dilakukan pelanggan.</p>

        @if ($orders->isEmpty())
            <div class="alert alert-info">Belum ada pesanan masuk.</div>
        @endif

        <table id="zero-conf" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Waktu Ambil</th>
                    <th>Metode Bayar</th>
                    <th>Status</th>
                    <th>Total Harga</th>
                    <th>Catatan</th>
                    <th>Item Pesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->customer->name ?? '-' }}</td>
                    <td>{{ $order->pickup_time ?? '-' }}</td>
                    <td>{{ ucfirst($order->payment_method) }}</td>
                    <td>
                        @if ($order->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif ($order->status == 'success')
                            <span class="badge bg-success">Sukses</span>
                        @elseif ($order->status == 'failed')
                            <span class="badge bg-danger">Gagal</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>{{ $order->note ?? '-' }}</td>
                    <td>
                        <ul class="list-disc ps-3">
                            @foreach ($order->orderItems as $item)
                                <li>{{ $item->foodItem->name ?? '-' }} x {{ $item->quantity }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('incoming-orders.show', $order->id) }}" class="btn btn-info btn-sm me-2">
                                <i class="fas fa-eye"></i>
                            </a>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Waktu Ambil</th>
                    <th>Metode Bayar</th>
                    <th>Status</th>
                    <th>Total Harga</th>
                    <th>Catatan</th>
                    <th>Item Pesanan</th>
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
<link href="{{asset('assets/css/main.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">
@endpush

@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/plugins/DataTables/datatables.min.js')}}"></script>

<script>
    $(document).ready(function () {
        $('#zero-conf').DataTable();
    });

    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let orderId = $(this).data('id');

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
                    url: "{{ url('incoming-orders') }}/" + orderId,
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
