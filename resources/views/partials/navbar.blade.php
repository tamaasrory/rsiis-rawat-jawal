<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom border-primary border-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo RSI Ibnu Sina" height="40" class="me-2">
            <span class="text-primary fw-bold">Rawat Jalan</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto fw-medium">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active text-primary' : '' }}"
                       href="{{ route('home') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pasien.*') ? 'active text-primary' : '' }}"
                       href="{{ route('pasien.index') }}">
                        <i class="bi bi-person-plus me-1"></i> Pendaftaran
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('asesmen.*') ? 'active text-primary' : '' }}"
                       href="{{ route('asesmen.index') }}">
                        <i class="bi bi-clipboard2-pulse me-1"></i> Asesmen
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active text-primary' : '' }}"
                       href="{{ route('laporan.index') }}">
                        <i class="bi bi-bar-chart-line me-1"></i> Laporan
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
