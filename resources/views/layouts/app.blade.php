<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiTernak') - Sistem Manajemen Ternak</title>

    {{-- Skydash CSS --}}
    <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    @stack('css')
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    {{-- SweetAlert2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">



</head>

<body>
    <div class="container-scroller">

        {{-- NAVBAR --}}
        @include('layouts.partials.navbar')

        <div class="container-fluid page-body-wrapper">

            {{-- SIDEBAR --}}
            @include('layouts.partials.sidebar')

            {{-- MAIN CONTENT --}}
            <div class="main-panel">
                <div class="content-wrapper">

                    @yield('content')
                </div>

                {{-- FOOTER --}}
                @include('layouts.partials.footer')
            </div>

        </div>
    </div>

    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    @stack('js')
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    {{-- SweetAlert untuk session flash --}}
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2500,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: true,
            });
        @endif

        @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: '{{ session('warning') }}',
                showConfirmButton: true,
            });
        @endif
    </script>

    {{-- SweetAlert konfirmasi hapus --}}
    <script>
        document.querySelectorAll('.btn-hapus').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const nama = this.dataset.nama || 'data ini';

                Swal.fire({
                    icon: 'warning',
                    title: 'Yakin hapus?',
                    text: `Data "${nama}" akan dihapus permanen!`,
                    showCancelButton: true,
                    confirmButtonColor: '#E33353',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>

</html>
