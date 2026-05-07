<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-heart-pulse me-1"></i> Rawat Jalan
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pasien.*') ? 'active' : '' }}"
                       href="{{ route('pasien.index') }}">
                        <i class="bi bi-person-plus me-1"></i> Pendaftaran
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('asesmen.*') ? 'active' : '' }}"
                       href="{{ route('asesmen.index') }}">
                        <i class="bi bi-clipboard2-pulse me-1"></i> Asesmen
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
                       href="{{ route('laporan.index') }}">
                        <i class="bi bi-bar-chart-line me-1"></i> Laporan
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
