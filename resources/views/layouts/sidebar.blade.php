<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; min-height: 100vh;">
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        {{-- MENU UNTUK SEMUA ROLE --}}
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        
        {{-- MENU PETA SIG KHUSUS ADMIN --}}
        @role('Admin')
        <li>
            <a href="{{ route('dashboard.sig') }}" class="nav-link text-white {{ request()->routeIs('dashboard.sig') ? 'active' : '' }}">
                <i class="fas fa-map me-2"></i> Peta SIG
            </a>
        </li>
        @endrole

        {{-- MENU KHUSUS ADMIN --}}
        @role('Admin')
        <li>
             <a href="{{ route('kelompok-tani.report') }}" class="nav-link text-white {{ request()->routeIs('kelompok-tani.report') ? 'active' : '' }}">
                <i class="fas fa-file-alt me-2"></i> Laporan Lahan
            </a>
        </li>
        <li>
        <a href="{{ route('reports.index') }}" class="nav-link text-white {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt me-2"></i> Laporan Komoditas
        </a>
    </li>
        <li>
            <a href="{{ route('users.index') }}" class="nav-link text-white {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog me-2"></i> Manajemen Akun
            </a>
        </li>
        @endrole

        {{-- MENU UNTUK ADMIN DAN KOMODITAS --}}
        @hasanyrole('Admin|Komoditas')
       <li>
            <a href="{{ route('kelompok-tani.index') }}" class="nav-link text-white {{ request()->routeIs('kelompok-tani.*') ? 'active' : '' }}">
                <i class="fas fa-users me-2"></i> Data Komoditas
            </a>
        </li>
        @endhasanyrole

        {{-- MENU UNTUK PETANI DAN ADMIN --}}
        @hasanyrole('Petani|Admin')
        <li>
            <a href="{{ route('lahan.index') }}" class="nav-link text-white {{ request()->routeIs('lahan.*') ? 'active' : '' }}">
                <i class="fas fa-map-marked-alt me-2"></i> Data Lahan Saya
            </a>
        </li>
        
        {{-- =============================================== --}}
        {{-- MENU BARU UNTUK PELAPORAN MASALAH --}}
        {{-- =============================================== --}}
        <li>
            <a href="{{ route('laporan-masalah.index') }}" class="nav-link text-white {{ request()->routeIs('laporan-masalah.*') ? 'active' : '' }}">
                <i class="fas fa-exclamation-triangle me-2"></i> Pelaporan Masalah
            </a>
        </li>
        @endhasanyrole
    </ul>
    <hr>
        {{-- KODE LOGOUT --}}
    <div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" class="nav-link text-white" 
               onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i>
                {{ __('Log Out') }}
            </a>
        </form>
    </div>
</div>