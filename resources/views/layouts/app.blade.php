<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi Pencatatan Pasien Rawat Jalan">
    <title>@yield('title', 'Dashboard') — Rawat Jalan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --bs-primary: #1b633f;
            --bs-primary-rgb: 27, 99, 63;
        }
        body { background-color: #f0f2f5; min-height: 100vh; display: flex; flex-direction: column; }
        main { flex: 1; }
        .navbar-brand { font-weight: 700; letter-spacing: -0.5px; }
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .table th { font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; }
        .badge { font-weight: 500; }
        .btn-loading { pointer-events: none; opacity: 0.7; }
        .empty-state { padding: 3rem 1rem; text-align: center; color: #6c757d; }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.4; }
    </style>
    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    <main class="container py-4">
        @hasSection('breadcrumb')
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-transparent p-0 mb-2">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">
                    <i class="bi bi-house-door"></i> Home
                </a></li>
                @yield('breadcrumb')
            </ol>
        </nav>
        @endif

        @include('partials.flash')

        @yield('content')
    </main>

    <footer class="border-top py-3 mt-auto bg-white">
        <div class="container text-center">
            <small class="text-muted">&copy; {{ date('Y') }} Aplikasi Pencatatan Pasien Rawat Jalan</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Loading state pada button form submission
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const btn = this.querySelector('[type="submit"]');
                if (btn && !btn.classList.contains('btn-loading')) {
                    btn.classList.add('btn-loading');
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
