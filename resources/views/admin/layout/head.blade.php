<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Dashboard - NHASACHTV</title>
    {{-- CSS --}}
    @if (!empty($config['css']))
        @foreach ($config['css'] as $css)
            <link rel="stylesheet" href="{{ asset($css) }}">
        @endforeach
    @endif
</head>



@if (session('success'))
    <div style="position: fixed; top: 1rem; right: 1rem; z-index: 1050;">
        <div id="toastSuccess" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto"><i class="lar la-check-circle"></i> Thành công</strong>
            </div>
            <div class="toast-body bg-light">
                {{ session('success') }}
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            let toast = document.getElementById('toastSuccess');
            if (toast) {
                let bsToast = new bootstrap.Toast(toast);
                bsToast.hide();
            }
        }, 5000);
    </script>
@endif

@if (session('error'))
    <div style="position: fixed; top: 1rem; right: 1rem; z-index: 1050;">

        <div id="toastError" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto"><i class="las la-exclamation-triangle"></i> Lỗi</strong>


            </div>
            <div class="toast-body bg-light">
                {{ session('error') }}
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            let toast = document.getElementById('toastError');
            if (toast) {
                let bsToast = new bootstrap.Toast(toast);
                bsToast.hide();
            }
        }, 5000);
    </script>
@endif



<style>
    .toast {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        border: none !important;
    }

    .toast-header {
        font-size: 1.1rem;
        padding: 0.75rem 1rem;
    }

    .toast-body {
        padding: 1rem;
        font-size: 1rem;
    }
</style>

<body>
