@extends('layout.main')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Detail Pesanan</h5>

        <div class="mb-3">
            <strong>Nama Pelanggan:</strong> {{ $order->customer->name ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Waktu Ambil:</strong> {{ $order->pickup_time ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Metode Bayar:</strong> {{ ucfirst($order->payment_method) }}
        </div>
        <div class="mb-3">
            <strong>Status:</strong>
            @if ($order->status == 'pending')
                <span class="badge bg-warning text-dark">Pending</span>
            @elseif ($order->status == 'success')
                <span class="badge bg-success">Sukses</span>
            @elseif ($order->status == 'failed')
                <span class="badge bg-danger">Gagal</span>
            @else
                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
            @endif
        </div>
        <div class="mb-3">
            <strong>Total Harga:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}
        </div>
        <div class="mb-3">
            <strong>Catatan:</strong> {{ $order->note ?? '-' }}
        </div>

        <hr>

        <h6>Item Pesanan:</h6>
        <ul class="list-group mb-4">
            @foreach ($order->orderItems as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $item->foodItem->name ?? '-' }}
                    <span>x {{ $item->quantity }}</span>
                </li>
            @endforeach
        </ul>

        <div class="d-flex gap-2">
            <button class="btn btn-success btn-status" data-status="success">Tandai Sukses</button>
            <button class="btn btn-danger btn-status" data-status="failed">Tandai Gagal</button>
            <button class="btn btn-warning text-dark btn-status" data-status="pending">Tandai Pending</button>
            <a href="{{ route('incoming-orders.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('.btn-status').click(function () {
        let status = $(this).data('status');

        Swal.fire({
            title: 'Ubah Status Pesanan?',
            text: `Yakin ingin mengubah status menjadi ${status}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Ubah',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('incoming-orders.update', $order->id) }}",
                    method: 'POST',
                    data: {
                        _method: 'PUT',
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function (res) {
                        Swal.fire('Sukses!', 'Status berhasil diubah.', 'success')
                            .then(() => location.reload());
                    },
                    error: function () {
                        Swal.fire('Gagal', 'Terjadi kesalahan.', 'error');
                    }
                });
            }
        });
    });
</script>
@endpush
