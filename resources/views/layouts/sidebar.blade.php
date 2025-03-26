<section id="sidebar" class="sidebar col-md-3 h-100 shadow position-fixed top-0 start-0" style="z-index: 1050;">
  <div class="company-logo d-flex justify-content-center align-items-center">
    <img src="{{ asset('icon/Logo.svg') }}" alt="Logo" class="logo-img me-3" />
    <h4 class="fw-bold">Apada<span class="text-span">Bali</span></h4>
  </div>
  
  <ul class="side-menu">
    @php
        $currentRoute = request()->path();
        $isDropdownActive = str_starts_with($currentRoute, 'Pencatatan-') || 
                           (str_starts_with($currentRoute, 'Data-') && str_contains($currentRoute, '-Keuangan')) || 
                           str_starts_with($currentRoute, 'Laporan-');
    @endphp
    
    @if(Auth::check())
        @if(Auth::user()->role === 'admin')
            <a href="{{ url('/dashboard-admin') }}" class="sidebar-link {{ $currentRoute == 'dashboard-admin' && !$isDropdownActive ? 'active bg-orange-500 text-white' : '' }}">
                <li class="d-flex align-items-center">
                    <img src="{{ asset('icon/dashboard.svg') }}" alt="icon" class="sidebar-icon me-4 {{ $currentRoute == 'dashboard-admin' && !$isDropdownActive ? 'filter-white' : '' }}" />
                    Dashboard
                </li>
            </a>
            <hr class="line-divider" />
            <li class="text-divider fw-bold mt-4">DATA</li>
        @else
            <a href="{{ url('/dashboard-drafter') }}" class="sidebar-link {{ $currentRoute == 'dashboard-drafter' ? 'active bg-orange-500 text-white' : '' }}">
                <li class="d-flex align-items-center">
                    <img src="{{ asset('icon/dashboard.svg') }}" alt="icon" class="sidebar-icon me-4 {{ $currentRoute == 'dashboard-drafter' ? 'filter-white' : '' }}" />
                    Dashboard
                </li>
            </a>
            <hr class="line-divider" />
            <li class="text-divider fw-bold mt-4">DATA</li>
        @endif
    @endif
    
    @if(Auth::check() && Auth::user()->role === 'admin')
      <!-- Pencatatan -->
      <li class="{{ str_starts_with($currentRoute, 'Pencatatan-') ? 'menu-open' : '' }}">
        <a href="#" class="{{ str_starts_with($currentRoute, 'Pencatatan-') && !str_contains($currentRoute, '-Keuangan') && !str_contains($currentRoute, 'Laporan-') ? 'active text-orange-500' : '' }}">
          <img src="{{ asset('icon/pencatatan proyek.svg') }}" alt="icon" class="sidebar-icon me-4" />
          Daftar Proyek <i class="bx bx-chevron-right icon-right"></i>
        </a>
        <ul class="slide-dropdown {{ str_starts_with($currentRoute, 'Pencatatan-') ? 'show' : '' }}">
          <li><a href="/Pencatatan-Proyek" class="{{ $currentRoute == 'Pencatatan-Proyek' ? 'active text-orange-500' : '' }}">Proyek</a></li>
          <li><a href="/Pencatatan-Furniture" class="{{ $currentRoute == 'Pencatatan-Furniture' ? 'active text-orange-500' : '' }}">Furniture</a></li>
        </ul>
      </li>
    @else
      <!-- Daftar Proyek untuk Drafter -->
      <a href="/Daftar-Proyek" class="sidebar-link {{ $currentRoute == 'Daftar-Proyek' ? 'active bg-orange-500 text-white' : '' }}">
        <li class="d-flex align-items-center">
          <img src="{{ asset('icon/pencatatan proyek.svg') }}" alt="icon" class="sidebar-icon me-4 {{ $currentRoute == 'Daftar-Proyek' ? 'filter-white' : '' }}" />
          Daftar Proyek
        </li>
      </a>
    @endif

    <!-- proyek khusus drafter -->

    
    <!-- Progres Proyek -->
    @if(Auth::check() &&Auth::user()->role === 'admin')
      <!-- Progres Proyek for Admin -->
      <a href="{{ url('/proyek/progress') }}" class="sidebar-link {{ $currentRoute == 'proyek/progress' ? 'active bg-orange-500 text-white' : '' }}">
        <li class="d-flex align-items-center">
          <img src="{{ asset('icon/progres proyek.svg') }}" alt="icon" class="sidebar-icon me-4 {{ $currentRoute == 'proyek/progress' ? 'filter-white' : '' }}" />
          Progres Proyek
        </li>
      </a>
    @else
      <!-- Progres Proyek for Drafter -->
      <a href="{{ url('/Progres-Proyek') }}" class="sidebar-link {{ $currentRoute == 'Progres-Proyek' ? 'active bg-orange-500 text-white' : '' }}">
        <li class="d-flex align-items-center">
          <img src="{{ asset('icon/progres proyek.svg') }}" alt="icon" class="sidebar-icon me-4 {{ $currentRoute == 'Progres-Proyek' ? 'filter-white' : '' }}" />
          Progres Proyek
        </li>
      </a>
    @endif

    @if(Auth::check() && Auth::user()->role === 'admin')
      <!-- Manajemen Keuangan -->
      <li class="{{ str_starts_with($currentRoute, 'Data-') && str_contains($currentRoute, '-Keuangan') ? 'menu-open' : '' }}">
        <a href="#" class="{{ str_starts_with($currentRoute, 'Data-') && str_contains($currentRoute, '-Keuangan') && !str_contains($currentRoute, 'Laporan-') ? 'active text-orange-500' : '' }}">
          <img src="{{ asset('icon/manajemen keuangan.svg') }}" alt="icon" class="sidebar-icon me-4" />
          Manajemen Keuangan <i class="bx bx-chevron-right icon-right"></i>
        </a>
        <ul class="slide-dropdown {{ str_starts_with($currentRoute, 'Data-') && str_contains($currentRoute, '-Keuangan') ? 'show' : '' }}">
          <li><a href="/Data-Pemasukan-Keuangan" class="{{ $currentRoute == 'Data-Pemasukan-Keuangan' ? 'active text-orange-500' : '' }}">Pemasukan</a></li>
          <li><a href="/Data-Pengeluaran-Keuangan" class="{{ $currentRoute == 'Data-Pengeluaran-Keuangan' ? 'active text-orange-500' : '' }}">Pengeluaran</a></li>
        </ul>
      </li>
      
      <!-- Manajemen Drafter -->
      <a href="/Data-Drafter" class="sidebar-link {{ request()->is('Data-Drafter') ? 'active text-orange-500' : '' }}">
        <li class="d-flex align-items-center">
          <img src="{{ asset('icon/manajemen drafter.svg') }}" alt="icon" class="sidebar-icon me-4" />
          Manajemen Drafter
        </li>
      </a>
      
      <!-- Manajemen Klien -->
      <a href="/Data-Klien" class="sidebar-link {{ request()->is('Data-Klien') ? 'active text-orange-500' : '' }}">
        <li class="d-flex align-items-center">
          <img src="{{ asset('icon/manajemen klien.svg') }}" alt="icon" class="sidebar-icon me-4" />
          Manajemen Klien
        </li>
      </a>
      
      <!-- Laporan -->
      <li class="{{ str_starts_with($currentRoute, 'Laporan-') ? 'menu-open' : '' }}">
        <a href="#" class="{{ str_starts_with($currentRoute, 'Laporan-') ? 'active text-orange-500' : '' }}">
          <img src="{{ asset('icon/laporan.svg') }}" alt="icon" class="sidebar-icon me-4" />
          Laporan <i class="bx bx-chevron-right icon-right"></i>
        </a>
        <ul class="slide-dropdown {{ str_starts_with($currentRoute, 'Laporan-') ? 'show' : '' }}">
          <li><a href="/Laporan-Pemasukan-Keuangan" class="{{ $currentRoute == 'Laporan-Pemasukan-Keuangan' ? 'active text-orange-500' : '' }}">Laporan Keuangan</a></li>
          <li><a href="/Laporan-Proyek" class="{{ $currentRoute == 'Laporan-Proyek' ? 'active text-orange-500' : '' }}">Laporan Proyek</a></li>
        </ul>
      </li>
    @endif
    
    <hr class="line-divider" />

    <!-- Logout button -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
    <button type="submit" class="logout d-flex align-items-center hover:to-blue-600">
      <img src="{{ asset('icon/logout.svg') }}" alt="icon" class="logout-icon me-4" />
      Log Out
    </button>
  </ul>
  
  <img src="{{ asset('icon/sidebar element.svg') }}" alt="element" class="element-sidebar mt-3" />
</section>