<!-- jQuery harus di-load terlebih dahulu -->
<script src="{{ asset('assets/plugins/jquery/jquery-3.4.1.min.js') }}"></script>

<!-- Library eksternal lainnya -->
<script defer src="https://unpkg.com/@popperjs/core@2"></script>
<script defer src="https://unpkg.com/feather-icons"></script>

<!-- Bootstrap -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Plugin lainnya -->
<script src="{{ asset('assets/plugins/perfectscroll/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>

<!-- Main Script -->
<script src="{{ asset('assets/js/main.min.js') }}"></script>

<!-- Halaman spesifik -->
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatables.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        feather.replace();
    });

    document.addEventListener("DOMContentLoaded", function() {
        const ps = new PerfectScrollbar('.your-scroll-container');
    });
</script>

